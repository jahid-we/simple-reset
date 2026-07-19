<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Settings {

    public function __construct() {
        add_action(
            'admin_init',
            [ $this, 'register_settings' ]
        );
    }

    public function register_settings() {
        // Global toggle to enable/disable all reset actions
        register_setting(
            'sr_settings_group',
            'sr_enable_reset',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '1',
            ]
        );

        // Require checking backup confirmation check box in modal
        register_setting(
            'sr_settings_group',
            'sr_require_backup',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '0',
            ]
        );

        // Send notification email to admin when any action executes
        register_setting(
            'sr_settings_group',
            'sr_email_alert',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '0',
            ]
        );

        // Comma separated list of allowed admin user IDs
        register_setting(
            'sr_settings_group',
            'sr_allowed_user_ids',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_text_field',
                'default'           => '',
            ]
        );

        // Custom warning message displayed on the Reset Tools page
        register_setting(
            'sr_settings_group',
            'sr_warning_message',
            [
                'type'              => 'string',
                'sanitize_callback' => 'sanitize_textarea_field',
                'default'           => '',
            ]
        );
    }

}
