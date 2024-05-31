<?php

require_once plugin_dir_path(__FILE__) . './getOlympDetails.php';
require_once plugin_dir_path(__FILE__) . './getOlympOrganizations.php';

function regFinalStage($request) {
    $olymp_slug = $request->get_param('olymp_slug');
    $organization_id = $request->get_param('organization_id');

    // Accepted organizations
    $accepted_organizations = getOrganizations($olymp_slug);
    $organization_ids = array_map(function($organization) {
        return $organization['id'];
    }, $accepted_organizations);

    // Проверяем, входит ли переданный organization_id в допустимые организации
    if (!in_array($organization_id, $organization_ids)) {
        return new WP_Error('invalid_organization', 'Указанная организация не допускается для этой олимпиады', array('status' => 400));
    }

    // Получаем ID организации (оргкомитета)
    $organization_post = get_post($organization_id);
    if (!$organization_post || $organization_post->post_type !== 'organizing_committee') {
        return new WP_Error('invalid_organization', 'Неверный идентификатор организации', array('status' => 400));
    }

    $olymp = getOlymp($olymp_slug);

    if (!$olymp) {
        return new WP_Error('no_olymp_found', 'Олимпиада с данным slug не найдена', array('status' => 404));
    }

    $olymp_title = $olymp['name'];
    $olymp_id = $olymp['ID'];

    // Формируем заголовок заявки
    $application_title = "Заявка на заключительный этап: " . $olymp_title . " - {" . $class . "} - [" . $year . "]";

    // Создаем новую запись типа "заявка"
    $postarr = array(
        'post_title' => $application_title,
        'post_type' => 'final_application',
        'post_status' => 'publish',
        'post_author' => get_current_user_id()
    );
    $application_id = wp_insert_post($postarr);

    // Добавляем метаполя для связи с оргкомитетом и олимпиадой
    if ($application_id) {
        update_post_meta($application_id, 'olymp_id', $olymp_id);
        update_post_meta($application_id, 'organization_id', $organization_id);
    }

    return new WP_REST_Response(array('application_id' => $application_id), 200);
}