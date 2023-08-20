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

use Enable\Cors\Plugin;
use Enable\Cors\Traits\Singleton;
use const Enable\Cors\NAME;

/**
 * Class Cors
 *
 * @package Enable\Cors
 */
final class Cors {
	use Singleton;

	/**
	 * It modifies the .htaccess file to add headers for allowing fonts and css
	 */
	public function modify_htaccess() {
		$lines = array(
			'<IfModule mod_headers.c>',
			'<FilesMatch "\.(ttf|ttc|otf|eot|woff|font.css|css|woff2)$">',
			'Header set Access-Control-Allow-Origin "*"',
			'Header set Access-Control-Allow-Credentials "true"',
			'</FilesMatch>',
			'</IfModule>',
			'<IfModule mod_headers.c>',
			'<FilesMatch "\.(avifs?|bmp|cur|gif|ico|jpe?g|jxl|a?png|svgz?|webp)$">',
			'Header set Access-Control-Allow-Origin "*"',
			'Header set Access-Control-Allow-Credentials "true"',
			'</FilesMatch>',
			'</IfModule>',
		);
		// Ensure get_home_path() is declared.
		$this->write_htaccess( $lines );

	}

	/**
	 * Inserts an array of strings into a file (.htaccess), placing it between
	 * BEGIN and END markers.
	 *
	 * @param array $lines need to write.
	 *
	 * @return void
	 */
	private function write_htaccess( array $lines ): void {
		// Ensure get_home_path() is declared.
		if ( ! function_exists( 'get_home_path' ) ) {
			require_once ABSPATH . 'wp-admin/includes/file.php';
		}

		$htaccess_file = get_home_path() . '.htaccess';

		if ( got_mod_rewrite() ) {
			insert_with_markers( $htaccess_file, NAME, $lines );
		}
	}

	/**
	 * It writes an empty array to the .htaccess file.
	 */
	public function restore_htaccess() {
		$lines = array( '' );
		$this->write_htaccess( $lines );
	}

	/**
	 * It sets headers for Cross-Origin Resource Sharing (CORS) based on options set in the
	 * plugin's settings.
	 *
	 * @return void If the `` variable is empty, the function will return nothing (void).
	 */
	public function headers(): void {
		$options = get_option( Plugin::OPTION );
		if ( empty( $options ) ) {
			return;
		}
		if ( array_key_exists( 'enable', $options ) && true === $options['enable'] ) {
			if ( array_key_exists( 'allowedFor', $options ) ) {
				$enable_cors_for = $this->get_origin( $options['allowedFor'] );
				header( 'Access-Control-Allow-Origin: ' . $enable_cors_for );
			}
			if ( array_key_exists( 'allowedMethods', $options ) ) {
				header( 'Access-Control-Allow-Methods: ' . $options['allowedMethods'] );
			}
			if ( array_key_exists( 'allowedHeader', $options ) ) {
				header( 'Access-Control-Allow-Headers: ' . $options['allowedHeader'] );
			}
			if ( array_key_exists( 'allowCredentials', $options ) ) {
				header( 'Access-Control-Allow-Credentials: ' . $options['allowCredentials'] );
			}
		}

	}

	/**
	 * It gets the value of the `enable_cors_for` option, and if it's empty, it returns `*`
	 *
	 * @param string $url from user input.
	 *
	 * @return string The origin of the request.
	 */
	private function get_origin( string $url ): string {
		$enable_cors_for = '*';
		if ( ! empty( $url ) ) {
			$enable_cors_for = $this->extract_origin( $url );
		}
		if ( empty( $enable_cors_for ) ) {
			$enable_cors_for = '*';
		}

		return $enable_cors_for;
	}

	/**
	 * Extract origin from user input.
	 *
	 * @param string $url URL from user input.
	 *
	 * @return string formatted URL for header.
	 */
	private function extract_origin( string $url ): string {
		$origin        = '';
		$parsed_domain = wp_parse_url( $url );
		if ( array_key_exists( 'scheme', $parsed_domain ) ) {
			$origin .= $parsed_domain['scheme'] . '://';
		}
		if ( array_key_exists( 'host', $parsed_domain ) ) {
			$origin .= $parsed_domain['host'];
		}
		if ( array_key_exists( 'port', $parsed_domain ) ) {
			$origin .= ':' . $parsed_domain['port'];
		}

		return $origin;
	}
}
