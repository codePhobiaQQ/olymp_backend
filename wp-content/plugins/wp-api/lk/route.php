<?php

require_once plugin_dir_path(__FILE__) . 'services/login.php';
require_once plugin_dir_path(__FILE__) . 'services/registration.php';

function lkEndpoints() {
    // Login route
    register_rest_route(
        'custom/v2',
        '/lk/login',

        array(
            'methods' => 'POST',
            'callback' => 'login',
            'permission_callback' => '__return_true',
            'args' => array(
                'login' => array(
                    'validate_callback' => 'sanitize_text_field'
                ),
                'password' => array(
                    'validate_callback' => 'sanitize_text_field'
                ),
            )
        )
    );

    // Registration route
    register_rest_route(
        'custom/v2',
        '/lk/test',

        array(
            'methods' => 'GET',
            'callback' => 'registration',
            'permission_callback' => '__return_true',
        )
    );
}