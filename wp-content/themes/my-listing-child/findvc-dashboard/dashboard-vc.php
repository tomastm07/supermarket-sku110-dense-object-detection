<?php
/**
 * @package Dashboard VC / FindVC
 * Template Name: Dashboard VC Index
 */

$dirFile = get_stylesheet_directory();

get_header('dashboard');

if(is_page(2511)){
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__init');
} elseif(is_page(2512)){
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__pitches');
} elseif(is_page(2513)){
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__upsell');
} elseif(is_page(2514)){
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__edit_profile');
} elseif(is_page(2515)){
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__investment_details');
} else {
    get_template_part('findvc-dashboard/templates/vc/dashboard-vc__password');
}

get_footer('dashboard');