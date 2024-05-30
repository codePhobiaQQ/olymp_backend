<?php

function register_organizing_committees_post_type() {
    $labels = array(
        'name'                  => 'Орг комитеты',
        'singular_name'         => 'Орг комитет',
        'add_new'               => 'Добавить новый',
        'add_new_item'          => 'Добавить новый орг комитет',
        'edit_item'             => 'Редактировать орг комитет',
        'new_item'              => 'Новый орг комитет',
        'view_item'             => 'Посмотреть орг комитет',
        'view_items'            => 'Посмотреть орг комитеты',
        'search_items'          => 'Найти орг комитет',
        'not_found'             => 'Орг комитеты не найдены',
        'not_found_in_trash'    => 'В корзине орг комитетов не найдено',
        'parent_item_colon'     => 'Родительский орг комитет:',
        'all_items'             => 'Все орг комитеты',
        'archives'              => 'Архивы орг комитетов',
        'attributes'            => 'Атрибуты орг комитетов',
        'insert_into_item'      => 'Вставить в орг комитет',
        'uploaded_to_this_item' => 'Загружено к этому орг комитету',
        'filter_items_list'     => 'Фильтровать список орг комитетов',
        'items_list_navigation' => 'Навигация по списку орг комитетов',
        'items_list'            => 'Список орг комитетов',
    );

    $args = array(
        'public' => true,
        'label'  => 'Орг комитеты',
        'labels' => $labels,
        'supports' => array( 'title', 'custom-fields', 'thumbnail' ),
        'menu_position' => 101,
//         'register_meta_box_cb' => 'add_organizing_committee_metaboxes',
        'menu_icon'     => 'dashicons-groups'
    );

    register_post_type( 'organizing_committee', $args );
}

// function add_organizing_committee_metaboxes() {
//     add_meta_box(
//         'organizing_committee_info',
//         'Информация о орг комитете',
//         'organizing_committee_info_callback',
//         'organizing_committee',
//         'normal',
//         'default'
//     );
// }
//
// function organizing_committee_info_callback( $post ) {
// }