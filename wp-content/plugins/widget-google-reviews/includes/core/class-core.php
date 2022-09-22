<?php

namespace WP_Rplg_Google_Reviews\Includes\Core;

class Core {

    public function __construct() {
    }

    public static function get_default_options() {
        return array(
            'view_mode'                 => 'list',
            'pagination'                => '10',
            'text_size'                 => '',
            'disable_user_link'         => false,
            'hide_based_on'             => false,
            'hide_writereview'          => false,
            'hide_reviews'              => false,

            'slider_hide_border'        => false,
            'slider_hide_prevnext'      => false,
            'slider_hide_dots'          => false,
            'slider_text_height'        => '',
            'slider_speed'              => 5,

            'header_merge_social'       => false,
            'header_hide_social'        => false,

            'dark_theme'                => false,
            'centered'                  => false,
            'max_width'                 => '',
            'max_height'                => '',

            'open_link'                 => true,
            'nofollow_link'             => true,
            'lazy_load_img'             => true,
            'google_def_rev_link'       => false,
            'reviewer_avatar_size'      => 56,
            'reviews_limit'             => '',
            'cache'                     => 12,
        );
    }

    public function get_reviews($feed, $is_admin = false) {
        $connection = json_decode($feed->post_content);

        if ($is_admin) {
            return $this->get_data($connection, $is_admin);
        }

        $cache_time            = isset($connection->options->cache) ? $connection->options->cache : null;
        $data_cache_key        = 'grw_feed_' . GRW_VERSION . '_' . $feed->ID . '_reviews';
        $connection_cache_key  = 'grw_feed_' . GRW_VERSION . '_' . $feed->ID . '_options';

        $data                  = get_transient($data_cache_key);
        $cached_connection     = get_transient($connection_cache_key);
        $serialized_connection = serialize($connection);

        if ($data === false || $serialized_connection !== $cached_connection || !$cache_time) {
            $expiration = $cache_time;
            switch ($expiration) {
                case '1':
                    $expiration = 3600;
                    break;
                case '3':
                    $expiration = 3600 * 3;
                    break;
                case '6':
                    $expiration = 3600 * 6;
                    break;
                case '12':
                    $expiration = 3600 * 12;
                    break;
                case '24':
                    $expiration = 3600 * 24;
                    break;
                case '48':
                    $expiration = 3600 * 48;
                    break;
                case '168':
                    $expiration = 3600 * 168;
                    break;
                default:
                    $expiration = 3600 * 24;
            }
            $data = $this->get_data($connection, $is_admin);
            set_transient($data_cache_key, $data, $expiration);
            set_transient($connection_cache_key, $serialized_connection, $expiration);
        }
        return $data;
    }

    public function get_data($connection, $is_admin = false) {

        if ($connection == null) {
            return null;
        }

        foreach ($this->get_default_options() as $field => $value) {
            $connection->options->{$field} = isset($connection->options->{$field}) ? esc_attr($connection->options->{$field}) : $value;
        }
        $options = $connection->options;

        if (isset($connection->connections) && is_array($connection->connections)) {
            $google_business = null;
            foreach ($connection->connections as $conn) {
                switch ($conn->platform) {
                    case 'google':
                        if (!$google_business) $google_business = array();
                        array_push($google_business, $conn);
                        break;
                }
            }
        } else {
            $google_business = isset($connection->google) ? $connection->google : null;
        }

        $google_biz = array();
        $google_reviews = array();

        if ($google_business != null) {

            $schedule_step = 60 * 60 * 12;

            foreach ($google_business as $biz) {

                $result = $this->get_google_reviews($biz, $is_admin);
                array_push($google_biz, $result['business']);
                $google_reviews = array_merge($google_reviews, $result['reviews']);

                if (isset($biz->refresh) && $biz->refresh) {
                    $args = array($biz->id);
                    if (isset($biz->lang) && strlen($biz->lang) > 0) {
                        array_push($args, $biz->lang);
                    }
                    $schedule_cache_key = 'grw_refresh_reviews_' . join('_', $args);
                    if (get_transient($schedule_cache_key) === false) {
                        wp_schedule_single_event(time() + $schedule_step, 'grw_refresh_reviews', array($args));
                        set_transient($schedule_cache_key, $schedule_cache_key, $schedule_step + 60 * 10);
                    }
                }
                $schedule_step = $schedule_step + 60 * 60 * 12;
            }
        }

        $social_biz = array();
        if ($options->header_merge_social) {
            if (count($google_biz) > 0) {
                array_push($social_biz, $this->merge_biz($google_biz));
            }
        } else {
            $social_biz = array_merge($google_biz);
        }

        $businesses = array();
        if (!$options->header_hide_social) {
            $businesses = $social_biz;
        }

        $reviews = array();
        if (!$options->hide_reviews) {

            $revs = array();
            if (count($google_reviews) > 0) {
                array_push($revs, $google_reviews);
            }

            // Sorting
            while (count($revs) > 0) {
                foreach ($revs as $i => $value) {
                    $review = array_shift($revs[$i]);
                    array_push($reviews, $review);
                    if (count($revs[$i]) < 1) {
                        unset($revs[$i]);
                    }
                }
            }

            // Normalize reviews array indexes after unset filter above
            $reviews = array_values($reviews);

            // Trim reviews limit
            if ($options->reviews_limit > 0) {
                $reviews = array_slice($google_reviews, 0, $options->reviews_limit);
            }
        }

        return array('businesses' => $businesses, 'reviews' => $reviews, 'options' => $options);
    }

    public function get_google_reviews($google_biz, $is_admin = false) {
        global $wpdb;

        // Get Google place
        $place = $wpdb->get_row(
            $wpdb->prepare(
                "SELECT * FROM " . $wpdb->prefix . Database::BUSINESS_TABLE .
                " WHERE place_id = %s", $google_biz->id
            )
        );

        // Get Google reviews
        $reviews_where = $is_admin ? '' : ' AND hide = \'\'';
        if (strlen($google_biz->lang) > 0) {
            $reviews_where = $reviews_where . ' AND language = \'' . $google_biz->lang . '\'';
        }
        $reviews = $wpdb->get_results(
            $wpdb->prepare(
                "SELECT * FROM " . $wpdb->prefix . Database::REVIEW_TABLE .
                " WHERE google_place_id = %d" . $reviews_where . " ORDER BY time DESC", $place->id
            )
        );

        // Setup Google photo
        $place->photo = strlen($google_biz->photo) > 0 ? $google_biz->photo : (strlen($place->photo) > 0 ? $place->photo : $place->icon);

        // Calculate Google reviews count
        if (isset($place->review_count) && $place->review_count > 0) {
            $review_count = $place->review_count;
        } else {
            $review_count = $wpdb->get_var(
                $wpdb->prepare(
                    "SELECT count(*) FROM " . $wpdb->prefix . Database::REVIEW_TABLE .
                    " WHERE business_id = %d", $place->id
                )
            );
        }

        // Calculate Google rating
        $rating = 0;
        if ($place->rating > 0) {
            $rating = $place->rating;
        } else if (count($reviews) > 0) {
            foreach ($reviews as $review) {
                $rating = $rating + $review->rating;
            }
            $rating = round($rating / count($reviews), 1);
        }
        $rating = number_format((float)$rating, 1, '.', '');

        $business = json_decode(json_encode(
            array(
                'id'                  => $google_biz->id,
                'name'                => $google_biz->name ? $google_biz->name : $place->name,
                'url'                 => $place->url,
                'photo'               => $place->photo,
                'address'             => $place->address,
                'rating'              => $rating,
                'review_count'        => $review_count,
                'provider'            => 'google'
            )
        ));

        $google_reviews = array();
        foreach ($reviews as $rev) {
            $review = json_decode(json_encode(
                array(
                    'id'            => $rev->id,
                    'hide'          => $rev->hide,
                    'biz_id'        => $google_biz->id,
                    'biz_url'       => $place->url,
                    'rating'        => $rev->rating,
                    'text'          => wp_encode_emoji($rev->text),
                    'author_avatar' => $rev->profile_photo_url,
                    'author_url'    => $rev->author_url,
                    'author_name'   => $rev->author_name,
                    'time'          => $rev->time,
                    'provider'      => 'google',
                )
            ));
            array_push($google_reviews, $review);
        }

        return array('business' => $business, 'reviews' => $google_reviews);
    }

    private function merge_biz($businesses, $id = '', $name = '', $url = '', $photo = '', $provider = '') {
        $count = 0;
        $rating = 0;
        $review_count = array();
        $review_count_manual = array();
        $business_platform = array();
        $biz_merge = null;
        foreach ($businesses as $business) {
            if ($business->rating < 1) {
                continue;
            }

            $count++;
            $rating += $business->rating;

            if (isset($business->review_count_manual) && $business->review_count_manual > 0) {
                $review_count_manual[$business->id] = $business->review_count_manual;
            } else {
                $review_count[$business->id] = $business->review_count;
            }

            array_push($business_platform, $business->provider);

            if ($biz_merge == null) {
                $biz_merge = json_decode(json_encode(
                    array(
                        'id'           => strlen($id)       > 0 ? $id       : $business->id,
                        'name'         => strlen($name)     > 0 ? $name     : $business->name,
                        'url'          => strlen($url)      > 0 ? $url      : $business->url,
                        'photo'        => strlen($photo)    > 0 ? $photo    : $business->photo,
                        'provider'     => strlen($provider) > 0 ? $provider : $business->provider,
                        'review_count' => 0,
                    )
                ));
            }
            $rating_tmp = round($rating / $count, 1);
            $rating_tmp = number_format((float)$rating_tmp, 1, '.', '');
            $biz_merge->rating = $rating_tmp;
        }
        $review_count = array_merge($review_count, $review_count_manual);
        foreach ($review_count as $id => $count) {
            $biz_merge->review_count += $count;
        }
        $biz_merge->platform = array_unique($business_platform);
        return $biz_merge;
    }

}