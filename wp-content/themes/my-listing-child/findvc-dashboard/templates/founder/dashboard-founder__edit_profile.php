<?php
/**
 * Dashboard Founder - Edit profile
 */

$get_myprofile  = GET_IMG . 'myprofile.png';
$get_linkedin  = GET_IMG . 'linkedin.svg';

?>
<style>
.profile-pic{background: url(<?php echo $get_myprofile; ?>);}
</style>

<section class="content">
	<div class="base-card container">
		<div class="wd-100">
            <section class="left-side">
                <?php get_template_part('findvc-dashboard/templates-parts/dashboard-menu'); ?>
            </section>
            <section class="right-side">
                <h4><?php echo the_title(); ?></h4>
                <div class="main-info-container">
                    <div class="profile-pic" style=""></div>
                    <div class="first-text-block">
                        <div id="nameblock">
                            <h4> WAYNE BERKSMAN </h4>
                            <div id="lkdlogo"><img src="<?php echo $get_linkedin; ?>"></div>
                        </div>
                        <h5> COO of Glass House </h5>
                        <h5> Miami-Fort Lauderdale Area </h5>
                    </div>
                </div>
                <form id="edit-profile" method="POST" action="">
                        <label for="fname">First Name
                            <input name="fname" placeholder="Uber Technologies, Inc" type="text">
                        </label>
                        <label for="lname">Last Name
                        <input name="lname" placeholder="Uber Technologies, Inc" type="text">
                        </label><br>
                        <label for="email">Email Address
                        <input name="email" placeholder="contact@ubertechnologies.com" type="email">
                        </label>
                        <label for="cnumber">Contact Number
                        <input name="cnumber" placeholder="San Francisco, California, US" type="text">
                        </label>
                        <hr>
                        <label for="stname">Start-up Name
                        <input name="stname" placeholder="Uber Technologies, Inc" type="text">
                        </label>
                        <label for="stindustry">Start-up Industry
                        <input name="stindustry" placeholder="Uber Technologies, Inc" type="text">
                        </label><br>
                        <label for="invsize">Investment Size
                        <input name="invsize" placeholder="Uber Technologies, Inc" type="text">
                        </label>
                        <label for="mthrev">Monthly Revenue
                        <input name="mthrev" placeholder="Uber Technologies, Inc" type="text">
                        </label><br>
                        <button type="submit">Save</button>
                    </form>
            </section>
		</div>
	</div>
</section>

<?php
?>