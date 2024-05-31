<?php

function register_final_stage_application_post_type() {
    $labels = array(
        'name'                  => 'Заявки на заключительный этап',
        'singular_name'         => 'Заявка на заключительный этап',
        'add_new'               => 'Добавить новую',
        'add_new_item'          => 'Добавить новую заявку',
        'edit_item'             => 'Редактировать заявку',
        'new_item'              => 'Новая заявка',
        'view_item'             => 'Посмотреть заявку',
        'view_items'            => 'Посмотреть заявки',
        'search_items'          => 'Найти заявку',
        'not_found'             => 'Заявки не найдены',
        'not_found_in_trash'    => 'В корзине заявок не найдено',
        'parent_item_colon'     => 'Родительская заявка:',
        'all_items'             => 'Все заявки',
        'archives'              => 'Архивы заявок',
        'attributes'            => 'Атрибуты заявок',
        'insert_into_item'      => 'Вставить в заявку',
        'uploaded_to_this_item' => 'Загружено к этой заявке',
        'filter_items_list'     => 'Фильтровать список заявок',
        'items_list_navigation' => 'Навигация по списку заявок',
        'items_list'            => 'Список заявок',
    );

    $args = array(
        'public' => true,
        'label'  => 'Заявки на заключительный этап',
        'labels' => $labels,
        'supports' => array('title', 'custom-fields', 'thumbnail'),
        'menu_position' => 101,
        'menu_icon' => 'dashicons-feedback',
    );

    register_post_type('final_application', $args);
}

function add_final_stage_application_metaboxes() {
    add_meta_box(
        'final_stage_application_info',
        'Информация о заявке',
        'final_stage_application_info_callback',
        'final_application',
        'normal',
        'default'
    );
}

function final_stage_application_info_callback($post) {
    // Получаем метаполя
    $olymp_id = get_post_meta($post->ID, 'olymp_id', true);
    $organization_id = get_post_meta($post->ID, 'organization_id', true);

    $olymp = get_post($olymp_id);
    $organization = get_post($organization_id);
    $user = get_userdata($post->post_author);

    // Отображаем метаполя
    echo '<p><strong>Пользователь:</strong> ' . esc_html($user->display_name) . ' (' . esc_html($user->user_email) . ')</p>';
    echo '<p><strong>Олимпиада:</strong> ' . ($olymp ? esc_html($olymp->name) : 'Не указано') . '</p>';
    echo '<p><strong>Организатор:</strong> ' . ($organization ? esc_html($organization->post_title) : 'Не указано') . '</p>';
}

function save_final_stage_application_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['olymp_id'])) {
        update_post_meta($post_id, 'olymp_id', intval($_POST['olymp_id']));
    }

    if (isset($_POST['organization_id'])) {
        update_post_meta($post_id, 'organization_id', intval($_POST['organization_id']));
    }
}