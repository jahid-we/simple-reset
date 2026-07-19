<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
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