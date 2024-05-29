<?php

require_once plugin_dir_path(__FILE__) . 'services/setMetadata.php';

function userEndpoints() {
    // Login route
    register_rest_route(
        'custom/v2',
        '/user/set-metadata',

        array(
            'methods' => 'POST',
            'callback' => 'setMetadata',
            'permission_callback' => 'is_user_logged_in',
        )
    );
}