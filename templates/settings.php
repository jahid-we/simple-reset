<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
$post_types = get_post_types(
    [
        'public'  => true,
        '_builtin' => false,
    ],
    'objects'
);

echo '<pre>';
print_r( $post_types );
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