<?php

require_once plugin_dir_path(__FILE__) . './getOlympDetails.php';

function regFinalStage($request) {
    $olymp_slug = $request->get_param('olymp_slug');
    $organization_id = $request->get_param('organization_id');

    // Получаем ID организации (оргкомитета)
    $organization_post = get_post($organization_id);
    if (!$organization_post || $organization_post->post_type !== 'organizing_committee') {
        return new WP_Error('invalid_organization', 'Неверный идентификатор организации', array('status' => 400));
    }

    print_r($organization_post);

    $olymp = getOlymp($olymp_slug);
    if (!$olymp) {
        return new WP_Error('no_olymp_found', 'Олимпиада с данным slug не найдена', array('status' => 404));
    }
    $olymp_id = $olymp->ID;

    // Создаем новую запись типа "заявка"
    $postarr = array(
        'post_title' => 'Заявка на заключительный этап олимпиады',
        'post_type' => 'application',
        'post_status' => 'publish',
        'post_author' => get_current_user_id() // ID текущего пользователя
    );
    $application_id = wp_insert_post($postarr);

    // Добавляем метаполя для связи с оргкомитетом и олимпиадой
    if ($application_id) {
        update_post_meta($application_id, 'olymp_id', $olymp_id);
        update_post_meta($application_id, 'organization_id', $organization_id);
    }

    return $application_id;
}