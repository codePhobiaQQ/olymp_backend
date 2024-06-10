<?php

require_once plugin_dir_path(__FILE__) . 'getQualifyingResults.php';
require_once plugin_dir_path(__FILE__) . '../../core/utils/get-current-academic-year.php';
require_once plugin_dir_path(__FILE__) . '../../core/functions/olymp/olymp.dto.php';
require_once plugin_dir_path(__FILE__) . 'getOlympsList.php';

function getAvailableFinalStages($request) {
    $user_id = get_current_user_id();
    if (!$user_id) {
        return new WP_Error('not_logged_in', 'Пользователь не авторизован', array('status' => 401));
    }

    $current_academic_year = getCurrentAcademicYear();
    $olymp_slugs = getAllOlympSlugs();

    $available_final_stages = [];
    $current_date = date('Y-m-d');

    foreach ($olymp_slugs as $slug) {
        $meta_key = $slug . '_' . $current_academic_year . '_qualifying_passed';
        $qualifying_passed = get_user_meta($user_id, $meta_key, true);
        if ($qualifying_passed) {
            $available_final_stages[] = $slug;
        }
    }

    $olymps_data = getOlympsList();

    $filtered_olymps_data = array_filter($olymps_data, function($olymp) use ($available_final_stages, $current_date) {
        $end_qualifying_date = $olymp['end_qualifying_date'];

        if (in_array($olymp['slug'], $available_final_stages)) {
            if ($current_date > $end_qualifying_date) {
                return true;
            }
            return false;
        }

        return false;
    });

    // Добавляем поле registration_closed для тех, у которых регистрация закончилась
    foreach ($filtered_olymps_data as &$olymp) {
        $start_finishing_date = $olymp['start_finishing_date'];
        if ($current_date >= $start_finishing_date) {
            $olymp['registration_closed'] = true;
        }
    }
    unset($olymp);

    // Приводим массив к нумерованному формату
    $filtered_olymps_data = array_values($filtered_olymps_data);

    return new WP_REST_Response($filtered_olymps_data, 200);
}