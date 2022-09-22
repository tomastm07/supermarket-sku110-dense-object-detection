<?php
/**
 * Dashboard Init.
 *
 * @package FindVC Dashboard
 */

$get_shortlist_icon         = GET_IMG . 'shortlist.svg';
$get_pitch_deck_icon        = GET_IMG . 'pitch-deck.svg';
$get_founder_resources_icon = GET_IMG . 'founder-resources.svg';
$get_account_icon           = GET_IMG . 'account.svg';

$data_links = array(
	'shortlist'        => array( 'My Shortlist', $get_shortlist_icon, 'founder-shortlist' ),
	'pitch-deck'       => array( 'Get pitch deck feedback', $get_pitch_deck_icon, 'founder-pitch' ),
	'founder-resource' => array( 'Essential Founder Resources', $get_founder_resources_icon, 'founder-resource' ),
	'account'          => array( 'Account', $get_account_icon, 'founder-account' ),
);
?>

<section class="dashboard-founder__init">
	<div class="container">
		<div class="dashboard-founder__init--content">
		<?php foreach ( $data_links as $item ) : ?>
				<div class="dashboard__link--item">
					<a class="dashboard__link--item__options" href="#" data-click=<?php echo $item[2]; ?>>
						<div class="dashboard__link--item--inner">
							<div class="dashboard__link--item--inner__icons">
								<img class="link_item__icon" src="<?php echo esc_url( $item[1] ); ?>" alt="my-item" loading="lazy">
							</div>
							<h2 class="link_item__title"><?php echo wp_kses_post( $item[0] ); ?></h2>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
