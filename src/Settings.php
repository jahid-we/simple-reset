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
        add_action(
            'admin_post_sr_export_settings',
            [ $this, 'handle_export' ]
        );
        add_action(
            'admin_post_sr_import_settings',
            [ $this, 'handle_import' ]
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

    public function handle_export() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to perform this action.' );
        }

        if ( ! isset( $_POST['sr_export_settings_nonce'] ) || ! wp_verify_nonce( $_POST['sr_export_settings_nonce'], 'sr_export_settings' ) ) {
            wp_die( 'Security check failed.' );
        }

        $allowed_options = [
            'sr_enable_reset',
            'sr_require_backup',
            'sr_email_alert',
            'sr_allowed_user_ids',
            'sr_warning_message',
        ];

        $options = [];

        foreach ( $allowed_options as $option ) {
            $options[ $option ] = get_option( $option, '' );
    }

        $file_name = 'simple-reset-config-' . date( 'Ymd_His' ) . '.json';

        header( 'Content-Description: File Transfer' );
        header( 'Content-Disposition: attachment; filename="' . $file_name . '"' );
        header( 'Content-Type: application/json; charset=utf-8' );
        header( 'Expires: 0' );
        header( 'Cache-Control: must-revalidate' );
        header( 'Pragma: public' );

        echo wp_json_encode( $options, JSON_PRETTY_PRINT );
        exit;
    }

    public function handle_import() {
        if ( ! current_user_can( 'manage_options' ) ) {
            wp_die( 'You do not have sufficient permissions to perform this action.' );
        }

        if ( ! isset( $_POST['sr_import_settings_nonce'] ) || ! wp_verify_nonce( $_POST['sr_import_settings_nonce'], 'sr_import_settings' ) ) {
            wp_die( 'Security check failed.' );
        }

        if ( empty( $_FILES['sr_import_file']['tmp_name'] ) ) {
            wp_die( 'No file uploaded.' );
        }

        $file_content = file_get_contents( $_FILES['sr_import_file']['tmp_name'] );
        $options      = json_decode( $file_content, true );

        if ( ! is_array( $options ) ) {
            wp_die( 'Invalid JSON file.' );
        }

        $allowed_options = [
            'sr_enable_reset',
            'sr_require_backup',
            'sr_email_alert',
            'sr_allowed_user_ids',
            'sr_warning_message',
        ];

        foreach ( $options as $key => $value ) {
            if ( in_array( $key, $allowed_options ) ) {
                update_option( $key, $value );
            }
        }

        wp_safe_redirect( admin_url( 'admin.php?page=simple-reset-settings&tab=reset_tools&sr_import_success=1' ) );
        exit;
    }

}
