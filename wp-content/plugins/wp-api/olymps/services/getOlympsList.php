<?php

//require get_template_directory() . './custom/consts.php';
require_once plugin_dir_path(__FILE__) . '/../../core/functions/getChildPages.php';
require_once plugin_dir_path(__FILE__) . '/../dto/getOlympsList.dto.php';

function getOlympsList() {
    $args = array(
        'post_type' => 'olymp',
    );
    $olymps = get_posts($args);

    $olymps_with_meta = array();

    foreach ($olymps as $olymp) {
        $fields = get_fields($olymp->ID);
        $type = $olymp->slug;

        // Получаем дату начала и окончания олимпиады
        $start_date = get_option('qualifying_stage_start_date_' . $type);
        $end_date = get_option('qualifying_stage_end_date_' . $type);
        $quiz = get_option('qualifying_stage_quiz_' . $type);

        // Проверяем, что $fields не является false, прежде чем добавлять его к массиву
        if ($fields !== false) {
            $fields['ID'] = $olymp->ID;
            $fields['start_date'] = $start_date;
            $fields['end_date'] = $end_date;
            $fields['quiz'] = $quiz;

            $olymps_with_meta[] = $fields;
        }
    }

    return $olymps_with_meta;
}