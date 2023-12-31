<?php

namespace Enable\Cors\Traits;

/*
|--------------------------------------------------------------------------
| If this file is called directly, abort.
|--------------------------------------------------------------------------
*/
if (!defined('Enable\Cors\NAME')) {
	exit;
}

use WP_Error;

trait Api
{
	/**
	 * The namespace of the API.
	 *
	 * @var string
	 */
	protected $namespace = 'enable-cors/v1';


	/**
	 * Check if a given request has access to get data from custom table
	 *
	 * @return WP_Error|bool
	 */
	public function permissions_check()
	{
		if (!current_user_can('manage_options')) {
			return new WP_Error(
				'rest_cannot_create',
				is_user_logged_in(),
				array('status' => rest_authorization_required_code())
			);
		}

		return true;
	}
}