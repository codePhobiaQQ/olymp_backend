<?php
require_once plugin_dir_path(__FILE__) . '/../dto/getNews.dto.php';

function getNews($params) {
    $page = absint($params->get_param('_page'));
    $limit = absint($params->get_param('_limit'));
    $orderby = $params->get_param('_orderby');
    $order = $params->get_param('_order');
    $categories = json_decode($params->get_param('categories'), true);
    
    // ----------- Validation ----------
    if ( ! in_array( $orderby, array( 'post_date', 'title' ) ) ) {
        $orderby = 'post_date';
    }
    if ( ! in_array( $order, array( 'ASC', 'DESC' ) ) ) {
        $order = 'ASC';
    }

    // ----------------------------------

    $args = array(
        'post_type' => 'new_news',
        'posts_per_page' => $limit,
        'paged' => $page,
        'orderby' => $orderby,
        'order' => $order,
    );

     if (!empty($categories) && is_array($categories)) {
       $args['tax_query'] = array(
         array(
           'taxonomy' => 'category',  // Название таксономии
           'field'    => 'term_id',    // Поле, по которому будем фильтровать
           'terms'    => $categories, // Массив категорий
           'operator' => 'IN',        // Оператор IN для выборки по категориям из переданного массива
         ),
       );
     }

    $posts = get_posts($args);

    if (empty($posts)) {
        return [];
    }

    return getNewsDTO($posts);
}