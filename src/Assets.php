<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Assets {

    public function __construct() {

        add_action(
            'admin_enqueue_scripts',
            [ $this, 'enqueue_assets' ]
        );

    }

   public function enqueue_assets($hook) {

     $allowed_hooks = [
        'toplevel_page_simple-reset',
        'reset_page_sr-reset-tools',
        'reset_page_sr-settings',
        'reset_page_sr-about',
    ];

    if ( ! in_array( $hook, $allowed_hooks, true ) ) {
        return;
    }
    wp_enqueue_style(
        'sr-admin',
        SR_URL . 'assets/css/style.css',
        [],
        SR_VERSION
    );

    wp_enqueue_script(
    'sr-admin',
    SR_URL . 'assets/js/script.js',
    [],
    SR_VERSION,
    true
);

}
}