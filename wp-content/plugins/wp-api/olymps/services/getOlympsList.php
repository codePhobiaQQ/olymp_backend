<?php

//require get_template_directory() . './custom/consts.php';
require_once plugin_dir_path(__FILE__) . '/../../core/functions/getChildPages.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getOlympsList.dto.php';

function getOlympsList() {
    $args = array(
        'post_type' => 'olymp',
        'posts_per_page' => -1,
    );

//     $args_quiz = array(
//         'post_type' => 'qsm_quiz',
//         'post_status' => 'publish',
//         'numberposts' => -1
//     );

    $olymps = get_posts($args);
//     $quizzes = get_posts($args_quiz);

    $olymps_with_meta = array();

    foreach ($olymps as $olymp) {
        $fields = get_fields($olymp->ID);
        $type = $olymp->slug;

        // Получаем дату начала и окончания олимпиады
        $start_qualifying_date = get_option('qualifying_stage_start_date_' . $type);
        $end_qualifying_date = get_option('qualifying_stage_end_date_' . $type);
        $start_finishing_date = get_option('finishing_stage_start_date_' . $type);
        $end_finishing_date = get_option('finishing_stage_end_date_' . $type);

        // Проверяем, что $fields не является false, прежде чем добавлять его к массиву
        $olymps_with_meta[] = array(
            'ID' => $olymp->ID,
            'name' => $olymp->post_title,
            'description' => $fields['description'],
            'start_qualifying_date' => $start_qualifying_date,
            'end_qualifying_date' => $end_qualifying_date,
            'start_finishing_date' => $start_finishing_date,
            'end_finishing_date' => $end_finishing_date,
            'slug' => $type,
        );
    }

    return $olymps_with_meta;
}