<?php

require_once plugin_dir_path(__FILE__) . '../../../../plugins/wp-api/core/functions/olymp/getOlympDataByName.php';
require_once plugin_dir_path(__FILE__) . '../../../../plugins/wp-api/core/utils/get-current-academic-year.php';

function qsm_check_passing_score($quiz_response, $quiz_result) {
    $user_id = get_current_user_id();
    $quiz_post_id = get_post_meta($quiz_result['quiz_id'], '_qsm_quiz_post_id', true);
    $points_to_pass = get_field('qsm_passing_score', $quiz_post_id);
    $user_points = $quiz_result['total_points'];

    $olymp_data = getOlympDataByName($quiz_result['quiz_name']);
    $olymp_slug = $olymp_data['slug'];
    $current_year = getCurrentAcademicYear();

    // Создаем ключ для мета-данных пользователя
    $meta_key = "{$olymp_slug}_{$current_year}_qualifying_passed";

    if ($user_points >= $points_to_pass) {
        update_user_meta($user_id, $meta_key, true);
        error_log("User passed the quiz with a score of at least $points_to_pass");
    } else {
        update_user_meta($user_id, $meta_key, false);
        error_log("User did not pass the quiz with a score of at least $points_to_pass");
    }

    return $quiz_response;
}