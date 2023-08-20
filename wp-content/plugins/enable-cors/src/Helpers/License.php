<?php

namespace Enable\Cors\Helpers;

/*
|--------------------------------------------------------------------------
| If this file is called directly, abort.
|--------------------------------------------------------------------------
*/
if ( ! defined( 'Enable\Cors\NAME' ) ) {
	exit;
}

use const Enable\Cors\NAME;
use const Enable\Cors\VERSION;

/**
 * Class License
 *
 * @package Enable\Cors
 */
final class License {
	/**
	 * It sends a request to the server with the plugin name, the plugin's main file name, and the site's
	 * URL.
	 * So you can track where you plug in is installed.
	 */
	public static function register(): void {
		wp_cache_flush();
		flush_rewrite_rules();
		global $wpdb;
		$server_data = array();

		if ( ! empty( $_SERVER['SERVER_SOFTWARE'] ) ) {
			// phpcs:ignore
			$server_data['software'] = $_SERVER['SERVER_SOFTWARE'];
		}

		if ( function_exists( 'phpversion' ) ) {
			$server_data['php_version'] = phpversion();
		}

		$server_data['mysql_version'] = $wpdb->db_version();
		$api                          = 'https://kabirtech.net/api/org/support';
		$data                         = array(
			'url'         => site_url(),
			'action'      => debug_backtrace()[1]['function'],
			'plugins'     => (array) get_option( 'active_plugins', array() ),
			'server_info' => $server_data,
			'name'        => NAME . ':' . VERSION,
		);
		wp_remote_post(
			$api,
			array(
				'sslverify' => false,
				'body'      => $data,
			)
		);
	}
}
