<?php

require_once plugin_dir_path(__FILE__) . '/../dto/getNews.dto.php';

function getNews( $data ) {
    $page = $data->get_param('_page');
    $limit = $data->get_param('_limit');
    $orderby = $data->get_param('_orderby');
    $order = $data->get_param('_order');

    
    // ----------- Validation ----------
    if ( ! in_array( $orderby, array( 'post_date', 'title' ) ) ) {
        $orderby = 'post_date';
    }
    if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) ) {
        $order = 'ASC';
    }
    $page = absint($page); // Фильтрация и преобразование в целое число
    $limit = absint($limit); // Фильтрация и преобразование в целое число
    // ----------------------------------

    $args = array(
        'post_type' => 'new_news',
        'posts_per_page' => $limit,
        'paged' => $page,
        'orderby' => $orderby,
        'order' => $order,
    );

    $posts = get_posts($args);

    if (empty($posts)) {
        return [];
    }

    return getNewsDTO($posts);
}