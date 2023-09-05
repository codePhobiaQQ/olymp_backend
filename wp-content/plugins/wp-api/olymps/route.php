<?php

require_once plugin_dir_path(__FILE__) . 'services/getOlympsList.php';
require_once plugin_dir_path(__FILE__) . 'services/getOlympDetails.php';

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

    // Get olymp Details by link
    register_rest_route(
        'custom/v2',
        '/olymps/(?P<olymp_link>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'GET',
            'callback' => 'getOlympDetails',
            'permission_callback' => '__return_true',
        )
    );
}