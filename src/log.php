<?php
namespace SimpleReset;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Log {

	/**
	 * Create activity log table.
	 */
	public static function create_table() {

		global $wpdb;

		$table_name      = $wpdb->prefix . 'sr_activity_logs';
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "
		CREATE TABLE $table_name (
			id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
			action varchar(100) NOT NULL,
			description text NULL,
			user_id bigint(20) unsigned NOT NULL,
			username varchar(100) NOT NULL,
			ip_address varchar(45) NULL,
			created_at datetime NOT NULL,
			PRIMARY KEY (id)
		) $charset_collate;
		";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		dbDelta( $sql );
	}

	/**
	 * Add activity log.
	 */
	public static function add( string $action, string $description = '' ) {

		global $wpdb;

		$table_name  = $wpdb->prefix . 'sr_activity_logs';
		$current_user = wp_get_current_user();

		$ip_address = sanitize_text_field(
			wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' )
		);

		$result = $wpdb->insert(
			$table_name,
			[
				'action'      => $action,
				'description' => $description,
				'user_id'     => $current_user->ID,
				'username'    => $current_user->user_login,
				'ip_address'  => $ip_address,
				'created_at'  => current_time( 'mysql' ),
			],
			[
				'%s',
				'%s',
				'%d',
				'%s',
				'%s',
				'%s',
			]
		);

		return false !== $result;
	}

	/**
	 * Get activity logs.
	 */
	public static function get() {

	global $wpdb;

	$table_name = $wpdb->prefix . 'sr_activity_logs';

	$sql = "
		SELECT *
		FROM $table_name
		ORDER BY created_at DESC
	";

	return $wpdb->get_results( $sql, ARRAY_A );
    }

    public static function clear() {

    global $wpdb;

    $table_name = $wpdb->prefix . 'sr_activity_logs';

    return $wpdb->query(
        "TRUNCATE TABLE $table_name"
    );
}
}