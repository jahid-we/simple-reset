<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$count = wp_count_posts( 'revision' );

echo '<pre>';
print_r( $count );
echo '</pre>';
?>

<div class="wrap">

    <h1>Simple Reset Settings</h1>

    <form method="post" action="options.php">

        <?php

        settings_fields( 'sr_settings_group' );

        do_settings_sections( 'sr-settings' );

        submit_button();

        ?>

    </form>

</div>