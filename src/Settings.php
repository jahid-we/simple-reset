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

            register_setting(
            "sr_settings_group",
            "sr_plugin_name",

            [
                "sanitize_callback" => "sanitize_text_field",
            ]
        );
        register_setting("sr_settings_group", "sr_enable_reset");
        register_setting("sr_settings_group", "sr_warning_message", [
            "sanitize_callback" => "sanitize_textarea_field",
        ]);

        add_settings_section(
            "sr_general_section",
            "General Settings",
            [$this, "general_section_callback"],
            "sr-settings"
        );
        add_settings_field(
            "sr_plugin_name",
            "Plugin Name",
            [$this, "plugin_name_callback"],
            "sr-settings",
            "sr_general_section"
        );

        add_settings_field(
            "sr_enable_reset",
            "Enable Reset",
            [$this, "enable_reset_callback"],
            "sr-settings",
            "sr_general_section"
        );
        add_settings_field(
            "sr_warning_message",
            "Warning Message",
            [$this, "warning_message_callback"],
            "sr-settings",
            "sr_general_section"
        );
    }
    public function general_section_callback()
    {
        echo "<p>Configure your Simple Reset plugin settings.</p>";
    }
    public function plugin_name_callback()
    {
        $value = get_option("sr_plugin_name", ""); ?>
    <input
        type="text"
        name="sr_plugin_name"
        value="<?php echo esc_attr($value); ?>"
        class="regular-text"
        placeholder="Reset"
    >
    <?php
    }

    public function enable_reset_callback()
    {
        $value = get_option("sr_enable_reset", 0); ?>

    <input
        type="checkbox"
        name="sr_enable_reset"
        value="1"
        <?php checked($value, 1); ?>
    >

    <?php
    }
    public function warning_message_callback()
    {
        $value = get_option("sr_warning_message", ""); ?>

        <textarea
            name="sr_warning_message"
            rows="4"
            class="large-text"
        ><?php echo esc_textarea($value); ?></textarea>

        <p class="description">
    Custom warning message shown on reset page.
        </p>

        <?php
    }


}

