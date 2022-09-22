<?php

/**
 * FindVC Dashboard - Shorlist.
 *
 * @package Find VC Dashboard
 */

require_once './json-obj.php';
$data = $json;
?>

<?php if ( ! empty( $data ) ) : ?>
<section class= 'fc-shortlist__section'>
	<div class="container">
		<div class="fc-shortlist__approved">
			<h2 class="fc-shortlist__approved--heading">Applied</h2>
			<table class="fc-shortlist__approved--inner">
			<div class="fc-shortlist__name--heading">
				<h4 class="fc-shortlist__name--heading__item">Investment Partner</h4>
				<h4 class="fc-shortlist__name--heading__item">VC Name</h4>
				<h4 class="fc-shortlist__name--heading__item">Why this VC</h4>
				<h4 class="fc-shortlist__name--heading__item">Current stage</h4>
				<h4 class="fc-shortlist__name--heading__item">Contact date</h4>
				<h4 class="fc-shortlist__name--heading__item">Warm Intros</h4>
				<h4 class="fc-shortlist__name--heading__item">Commitment</h4>
				<h4 class="fc-shortlist__name--heading__item">Status</h4>
			</div>
			<?php foreach ( $data as $elem ) : ?>
				<?php
					$partner_name         = $elem['investment_partner_name'];
					$partner_vc_name      = $elem['vc_name'];
					$partner_whyvc        = $elem['why_vc'];
					$partner_location     = $elem['location'];
					$partner_contact_date = $elem['contact_date'];
					$partner_warm_intros  = $elem['warm_intros'];
					$partner_commitment   = $elem['commitment'];
					$partner_status       = $elem['status'];
				?>
				<tr class="fc-shortlist__approved--inner__item">
					<td class="fc-shortlist__name">
						<span><?php echo $partner_name; ?></span>
					</td>
					<td class="fc-shortlist__vcname">
						<span><?php echo $partner_vc_name; ?></span>
					</td>
					<td class="fc-shortlist__whyvc">
						<span><?php echo $partner_whyvc; ?></span>
					</td>
					<td class="fc-shortlist__location">
						<span><?php echo $partner_location; ?></span>
					</td>
					<td class="fc-shortlist__contact-date">
						<span><?php echo $partner_contact_date; ?></span>
					</td>
					<td class="fc-shortlist__warm-intros">
						<span><?php echo $partner_warm_intros; ?></span>
					</td>
					<td class="fc-shortlist__commitment">
						<span><?php echo $partner_commitment; ?></span>
					</td>
					<td class="fc-shortlist__status">
						<span><?php echo $partner_status; ?></span>
					</td>
				</tr>
			<?php endforeach; ?>
			</table>
		</div>
	</div>
</section >
<?php endif; ?>
