<?php

function getOlympsListDTO( $pages ) {

    $olymps_data = array();

    foreach ($pages as $page) {
        $category_item = array(
            'id' => $page->ID,
            'name' => get_field('olymp_name', $page->ID),
            'preview_image' => get_field('olymp_preview_image', $page->ID),
            'link' => get_field('olymp_link', $page->ID),
        );

        $olymps_data[] = $category_item;
    }

    return $olymps_data;
}