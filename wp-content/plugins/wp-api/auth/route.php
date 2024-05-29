<?php

require_once plugin_dir_path(__FILE__) . 'services/registration.php';
require_once plugin_dir_path(__FILE__) . 'services/send-approval-email.php';
require_once plugin_dir_path(__FILE__) . 'services/approve-email.php';

function authEndpoints() {
    // Login was done by the lib JWT wordpress auth

    // Registration route
    register_rest_route(
        'custom/v2',
        '/auth/registration',

        array(
            'methods' => 'POST',
            'callback' => 'registration',
            'permission_callback' => '__return_true',
            'args' => array(
                'username' => array(
                    'validate_callback' => 'sanitize_text_field'
                ),
                'password' => array(
                    'validate_callback' => 'sanitize_text_field'
                ),
            )
        )
    );

    // Approve email route
    register_rest_route(
        'custom/v2',
        '/auth/approve-email',

        array(
            'methods' => 'POST',
            'callback' => 'approve_email',
            'permission_callback' => '__return_true',
        )
    );

    // Send approval email
    register_rest_route(
        'custom/v2',
        '/auth/send-approval-email',

        array(
            'methods' => 'POST',
            'callback' => 'send_approval_email',
            'permission_callback' => '__return_true',
        )
    );
}