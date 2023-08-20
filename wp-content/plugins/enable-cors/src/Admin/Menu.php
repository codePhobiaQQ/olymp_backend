<?php

namespace Enable\Cors\Admin;

/*
|--------------------------------------------------------------------------
| If this file is called directly, abort.
|--------------------------------------------------------------------------
*/
if ( ! defined( 'Enable\Cors\NAME' ) ) {
	exit;
}

use Enable\Cors\Traits\Singleton;
use const Enable\Cors\NAME;
use const Enable\Cors\URL;
use const Enable\Cors\VERSION;

/**
 * Class Menu
 *
 * @package Enable\Cors
 */
final class Menu {

	use Singleton;


	/**
	 * It registers the menu page for admin.
	 *
	 * @return void
	 */
	public function register() {
		add_menu_page(
			__( 'Enable CORS', 'enable-cors' ),
			__( 'Enable CORS', 'enable-cors' ),
			'manage_options',
			'enable-cors',
			array( $this, 'render' )
		);
	}

	/**
	 * It will display dashboard template. Also remove admin footer text.
	 *
	 * @return void
	 */
	public function render() {
		echo wp_kses_post( '<div id="' . NAME . '"></div>' );
	}

	/**
	 * It will add module attribute to script tag.
	 *
	 * @param  string  $tag  of script.
	 * @param  string  $id  of script.
	 *
	 * @return string
	 */
	public function add_module( string $tag, string $id ): string {
		if ( NAME === $id ) {
			$tag = str_replace( '<script ', '<script type="module" ', $tag );
		}

		return $tag;
	}

	/**
	 * It loads scripts based on plugin's mode, dev or prod.
	 *
	 * @return void
	 */
	public function scripts() {
			wp_enqueue_style( NAME, URL . 'assets/dist/index.css', array(), VERSION );
			wp_enqueue_script( NAME, URL . 'assets/dist/index.js', array( 'wp-i18n' ), VERSION, true );
		wp_localize_script(
			NAME,
			'enable_cors',
			array(
				'nonce'    => wp_create_nonce( 'wp_rest' ),
				'endpoint' => get_rest_url(),
				'strings'  => [
					'notify'  => [ 'settings' => __( "Please check your settings.", 'enable-cors' ) ],
					'form'    => [
						'enable'  => [
							'label' => __( 'Enable CORS', 'enable-cors' ),
							'hint'  => __( 'Configure the server to include CORS headers in the response to allow cross-origin requests.',
								'enable-cors' )
						],
						'website' => [
							'label'   => __( 'Allowed Websites', 'enable-cors' ),
							'hint'    => __( 'Specify the specific website (e.g., https://devkabir.shop) that is allowed to make requests.',
								'enable-cors' ),
							'invalid' => __( 'Enter a website domain like https://example.com', 'enable-cors' )
						],
						'method'  => [
							'label'   => __( 'Allowed Request Methods', 'enable-cors' ),
							'hint'    => __( 'Specify the allowed HTTP methods (e.g., GET,POST,OPTIONS) for cross-origin requests.',
								'enable-cors' ),
							'invalid' => __( 'Invalid HTTP methods', 'enable-cors' )
						],
						'header'  => [
							'label'   => __( 'Set Response Headers', 'enable-cors' ),
							'hint'    => __( 'Set the desired response headers (e.g., Content-Type,Authorization) to be included in the response for other websites.',
								'enable-cors' ),
							'invalid' => __( 'Invalid HTTP headers', 'enable-cors' )
						],
						'cred'    => [
							'label' => __( 'Allow Credentials', 'enable-cors' ),
							'hint'  => __( 'Configure the server to allow credentials (such as cookies or authorization headers) to be included in the cross-origin request.',
								'enable-cors' ),
						],
						'save'    => __( 'Save', 'enable-cors' ),
						'reset'   => __( 'Reset', 'enable-cors' )
					],
					'credits' => [
						'title'        => __( 'Thank You', 'enable-cors' ),
						'mehbubrashid' => [
							'issue' => __( 'Found issue on non-root server installations', 'enable-cors' )
						]
					],
					'notice'  => [
						'title'    => __( 'Notice', 'enable-cors' ),
						'empty'    => __( 'To enable CORS on your site, please save settings.', 'enable-cors' ),
						'endpoint' => __( 'Your API endpoint is', 'enable-cors' ),
						'star'     => __( ' means that any website can send a request to your
      WordPress site and access the server\'s response. This can be a potential
      security risk.', 'enable-cors' )
					]
				]
			)
		);
	}
}
