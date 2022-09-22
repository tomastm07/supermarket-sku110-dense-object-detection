<?php
/**
 * Dashboard Founder - Password & Security
 */

?>

<section class="content">
	<div class="base-card container">
		<div class="wd-100">
            <section class="left-side">
                <?php get_template_part('findvc-dashboard/templates-parts/dashboard-menu'); ?>
            </section>
            <section class="right-side">
                <h4 class="title">Change Password</h4>
                <form id="security-form" method="POST" action="">
                        <label for="cpass">Current Password
                            <input name="cpass" type="password">
                        </label><br>
                        <label for="npass">New Password
                        <input name="npass" type="password">    
                        </label><br>
                        <label for="confpass">Confirm Password
                        <input name="confpass" type="password">
                        </label><br>
                        <button type="submit">Save</button>
                    </form>
            </section>
		</div>
	</div>
</section>

<?php
?>