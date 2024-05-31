<?php

function getQualifyingResults() {
global $wpdb;
    $user_id = get_current_user_id();

    if (!$user_id) {
        return new WP_Error('not_logged_in', 'Пользователь не авторизован', array('status' => 401));
    }

    // Получаем результаты пользователя из таблицы wp_mlw_results
    $results_table = $wpdb->prefix . 'mlw_results';
    $results = $wpdb->get_results(
        $wpdb->prepare(
            "SELECT * FROM $results_table WHERE user = %d",
            $user_id
        )
    );

    if (empty($results)) {
        return new WP_Error('no_results_found', 'Результаты не найдены', array('status' => 404));
    }

    // Формируем массив с результатами
    $response = array();
    foreach ($results as $result) {
        // Преобразуем время и дату прохождения теста
        $datetime_taken = date('Y-m-d H:i:s', strtotime($result->time_taken));
        $date_taken = date('Y-m-d', strtotime($result->time_taken));
        $time_taken = date('H:i:s', strtotime($result->time_taken));

        $response[] = array(
            'result_id' => $result->result_id,
            'quiz_id' => $result->quiz_id,
            'quiz_name' => $result->quiz_name,
            'point_score' => $result->point_score,
            'correct_score' => $result->correct_score,
            'correct' => $result->correct,
            'total' => $result->total,
            'date' => $date_taken,
            'time' => $time_taken,
            'datetime' => $datetime_taken // добавляем datetime под правильным ключом
        );
    }

    // Сортируем результаты по datetime в обратном порядке
    usort($response, function($a, $b) {
        return strtotime($b['datetime']) - strtotime($a['datetime']);
    });

    return $response;
}

function getQualifyingResultsCallback($request) {
    return new WP_REST_Response(getQualifyingResults(), 200);
}
