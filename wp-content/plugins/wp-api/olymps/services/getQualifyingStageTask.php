<?php

function getQualifyingStageTask($request) {
    $olymp_slug = $request->get_param('olymp_slug');
    $quiz_id = get_option('qualifying_stage_quiz_' . $olymp_slug);
    $quiz_shortcode = get_post($quiz_id)->post_content;
//    return do_shortcode($quiz_shortcode);
    return do_shortcode('[qsm quiz=2]');
}