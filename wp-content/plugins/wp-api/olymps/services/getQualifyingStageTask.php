<?php

function getQuiz() {
    echo do_shortcode( '[qsm quiz=2]' );
}

function getQualifyingStageTask($request)
{
    $olymp_slug = $request->get_param('olymp_slug');
    $quiz_id = get_option('qualifying_stage_quiz_' . $olymp_slug);
    // $quiz_content = get_post_field('post_content', $quiz_id);

    $quiz_content = do_shortcode( '[qsm quiz=2]' );

    $content = get_header() . getQuiz() . "<div id='mountHere'></div>" . get_footer();

    return new WP_REST_Response(
        $content,
        200, array('content-type' => 'text/html; charset=UTF-8'));

//    $quiz_shortcode = get_post($quiz_id)->post_content;
//    return do_shortcode($quiz_shortcode);
//    return do_shortcode('[qsm quiz=2]');
}