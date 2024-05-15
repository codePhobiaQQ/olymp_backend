<?php

function getQualifyingStageTask($request) {
    $olymp_slug = $request->get_param('olymp_slug');
    $quiz_id = get_option('qualifying_stage_quiz_' . $olymp_slug);
    $quiz_content = get_post_field('post_content', $quiz_id);

    $template_content = file_get_contents('content.php');
    return new WP_REST_Response($template_content, 200, array('Content-Type' => 'text/html'));

//    return $quiz_content;

//    $quiz_shortcode = get_post($quiz_id)->post_content;
//    return do_shortcode($quiz_shortcode);
//    return do_shortcode('[qsm quiz=2]');
}