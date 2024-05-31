<?php

require_once plugin_dir_path(__FILE__) . 'getQualifyingResults.php';
require_once plugin_dir_path(__FILE__) . '../../core/utils/get-current-academic-year.php';

function getAvailableFinalStages($request) {
    $user_id = get_current_user_id();

    if (!$user_id) {
        return new WP_Error('not_logged_in', 'Пользователь не авторизован', array('status' => 401));
    }

    $qualifying_results = getQualifyingResults();
    $current_academic_year = getCurrentAcademicYear();

    echo $current_academic_year;

    //  TODO: make detection of correct quiz
    return 123;
}