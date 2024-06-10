<?php

function qsm_check_passing_score($quiz_response, $quiz_result) {
    $quiz_post_id = get_post_meta($quiz_result['quiz_id'], '_qsm_quiz_post_id', true);
    $points_to_pass = get_field('qsm_passing_score', $quiz_post_id);
    $user_points = $quiz_result['total_points'];

    if ($user_points >= $points_to_pass) {
        error_log("User passed the quiz with a score of at least $points_to_pass");
    } else {
        error_log("User did not pass the quiz with a score of at least $points_to_pass");
    }

    return $quiz_response;
}

// [total_points] => 0
// [total_score] => 100
// [total_correct] => 1
// [total_questions] => 1

// [total_points] => 1
// [total_score] => 100
// [total_correct] => 1
// [total_questions] => 1