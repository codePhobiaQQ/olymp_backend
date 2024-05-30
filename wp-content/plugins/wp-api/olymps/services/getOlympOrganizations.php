<?php

function getOlympOrganizations($request) {
    $olymp_slug = $request->get_param('olymp_slug');

    // Найдем пост олимпиады по её slug
    $olymp_query = new WP_Query(array(
        'post_type' => 'olymp',
        'posts_per_page' => 1
    ));

    if (!$olymp_query->have_posts()) {
        return new WP_Error('no_olymp_found', 'Олимпиада с данным slug не найдена', array('status' => 404));
    }

    $olymp_post = $olymp_query->posts[0];
    $olymp_id = $olymp_post->ID;

    print_r($olymp_id);

    // Получим участников оргкомитета, связанных с данной олимпиадой через метаполе accepted_olymps
    $committee_query = new WP_Query(array(
        'post_type' => 'organizing_committee',
        'posts_per_page' => -1,
//         'meta_query' => array(
//             array(
//                 'key' => 'accepted_olymps',
//                 'value' => '"' . $olymp_id . '"',
//                 'compare' => 'LIKE'
//             )
//         )
    ));

    $committees = array();

    if ($committee_query->have_posts()) {
        while ($committee_query->have_posts()) {
            $committee_query->the_post();

            $meta_data = get_post_meta(get_the_ID());
            print_r($meta_data['accepted_olymps'][0]);

            $committees[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'content' => get_the_content()
            );
        }
        wp_reset_postdata();
    } else {
        return new WP_Error('no_committees_found', 'У данной олимпиады нет участников оргкомитета', array('status' => 404));
    }

    return new WP_REST_Response($committees, 200);
}