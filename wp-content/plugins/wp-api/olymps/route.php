<?php

require_once plugin_dir_path(__FILE__) . 'services/getOlympsList.php';
require_once plugin_dir_path(__FILE__) . 'services/getOlympDetails.php';
require_once plugin_dir_path(__FILE__) . 'services/getQualifyingStageTask.php';
require_once plugin_dir_path(__FILE__) . 'services/getOlympOrganizations.php';
require_once plugin_dir_path(__FILE__) . 'services/regFinalStage.php';
require_once plugin_dir_path(__FILE__) . 'services/getQualifyingResults.php';
require_once plugin_dir_path(__FILE__) . 'services/getAvailableFinalStages.php';

function regOlympsEndpoints() {
    register_rest_route(
        'custom/v2',
        '/olymps',

        array(
            'methods' => 'GET',
            'callback' => 'getOlympsList',
            'permission_callback' => '__return_true',
        )
    );

    register_rest_route(
            'custom/v2',
            '/olymps/qualifying/results',

            array(
                'methods' => 'GET',
                'callback' => 'getQualifyingResultsCallback',
                'permission_callback' => 'is_user_logged_in',
            )
        );

    register_rest_route(
        'custom/v2',
        '/olymps/qualifying/(?P<olymp_slug>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'GET',
            'callback' => 'getQualifyingStageTask',
           'permission_callback' => 'is_user_logged_in',
        )
    );

    register_rest_route(
        'custom/v2',
        '/olymp-organizations/(?P<olymp_slug>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'GET',
            'callback' => 'getOlympOrganizations',
            'permission_callback' => '__return_true',
        )
    );

    register_rest_route(
        'custom/v2',
        '/olymps/reg-final-stage/(?P<olymp_slug>[a-zA-Z0-9_\-]+)',

        array(
            'methods' => 'POST',
            'callback' => 'regFinalStage',
            'permission_callback' => 'is_user_logged_in',
        )
    );

    register_rest_route(
        'custom/v2',
        '/olymps/available-final-stages',

        array(
            'methods' => 'GET',
            'callback' => 'getAvailableFinalStages',
            'permission_callback' => 'is_user_logged_in',
        )
    );

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