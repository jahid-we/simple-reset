<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Plugin {

    /**
     * Store the only instance.
     */
    private static $instance = null;

    /**
     * Constructor
     */
    private function __construct() {

        new Admin();
        new Settings();
        new Assets();
        new Reset();

    }

    private function maybe_upgrade() {

        if ( ! Log::table_exists() ) {

            Log::create_table();

        }

    }

    /**
     * Get instance.
     */
    public static function get_instance() {

        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}