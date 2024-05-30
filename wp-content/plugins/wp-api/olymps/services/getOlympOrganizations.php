<?php

require_once plugin_dir_path(__FILE__) . 'getOlympDetails.php';

function getOlympOrganizations($request) {
    $olymp_slug = $request->get_param('olymp_slug');
    $olymp = getOlymp($olymp_slug);

    if (is_wp_error($olymp)) {
        // RETURN ERROR
        return $olymp;
    }

    $olymp_id = $olymp['ID'];

    // Получим участников оргкомитета, связанных с данной олимпиадой через метаполе accepted_olymps
    $committee_query = new WP_Query(array(
        'post_type' => 'organizing_committee',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => 'accepted_olymps',
                'value' => '"' . $olymp_id . '"',
                'compare' => 'LIKE'
            )
        )
    ));

    $committees = array();

    if ($committee_query->have_posts()) {
        while ($committee_query->have_posts()) {
            $committee_query->the_post();
            $meta_data = get_post_meta(get_the_ID());
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