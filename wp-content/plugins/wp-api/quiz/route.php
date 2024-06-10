<?php

require_once plugin_dir_path(__FILE__) . 'services/testQuizComplete.php';

function quizEndpoints() {
    // Login route
    register_rest_route(
        'custom/v2',
        '/quiz/test',

        array(
            'methods' => 'POST',
            'callback' => 'qsm_test_check_passing_score',
            'permission_callback' => '__return_true',
        )
    );
}