<?php

require_once plugin_dir_path(__FILE__) . 'services/getOlympsList.php';
require_once plugin_dir_path(__FILE__) . 'services/getOlympDetails.php';
require_once plugin_dir_path(__FILE__) . 'services/getQualifyingStageTask.php';

function regOlympsEndpoints() {
    // Get Olymps list
    register_rest_route(
        'custom/v2',
        '/olymps',

        array(
            'methods' => 'GET',
            'callback' => 'getOlympsList',
            'permission_callback' => '__return_true',
        )
    );

    // Get qualifying stage task
    register_rest_route(
        'custom/v2',
        '/olymps/qualifying/(?P<olymp_slug>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'GET',
            'callback' => 'getQualifyingStageTask',
           'permission_callback' => 'is_user_logged_in',
        )
    );

    // Get olymp Details by link
    register_rest_route(
        'custom/v2',
        '/olymps/(?P<olymp_slug>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'GET',
            'callback' => 'getOlympDetails',
            'permission_callback' => '__return_true',
        )
    );
}