<?php
/**
 * Dashboard Initial 
 */

$centralOptions = array(
    0 => array(
        'name' => 'Pitch Submissions',
        'url'  => 'pitch_submissions'
    ),
    1 => array(
        'name' => 'Unlock More Dealflow',
        'url'  => 'unlock_dealflow'
    ),
    2 => array(
        'name' => 'My Account',
        'url'  => 'my_account'
    )
);
?>

<div class="dashboard-init_content">
    <div class="dashboard-init_content-grid">
        <?php foreach ($centralOptions as $index => $option) : ?>
            <div class="dashboard-init_content-grid-center <?php $index == 0 ?  printf(esc_html('wrap-primary')) : printf(esc_html('wrap_secondary')) ?>">

            </div>
        <?php endforeach; ?>
    </div>
</div>