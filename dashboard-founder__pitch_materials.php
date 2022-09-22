<?php
    require('wp-load.php');
    get_header('dashboard');
?>

<style>
    <?php include 'wp-content\themes\my-listing-child\findvc-dashboard\src\css\dashboard-profile.css'; ?>
    .profile-pic{background: url(<?php echo $get_myprofile; ?>);}
    body{
        margin-top: 0!important;
    }
</style>

<section class="content">
	<div class="base-card container">
		<div class="wd-100">
            <section class="left-side">
                <?php get_template_part('findvc-dashboard/templates-parts/dashboard-menu'); ?>
            </section>
            <section class="right-side">

            </section>
		</div>
	</div>
</section>

<?php
    get_footer('dashboard');
?>