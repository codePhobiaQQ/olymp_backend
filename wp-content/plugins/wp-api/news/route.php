<?php

require_once plugin_dir_path(__FILE__) . 'services/getNews.php';

function registerNewsEndpoints() {
    register_rest_route(
        'custom/v2',
        '/news',

        array(
            'methods' => 'GET',
            'callback' => 'getNews',
            'orderby' => 'post_date',
            'order' => 'DESC',

            'args' => array(
                '_page' => array(
                    'sanitize_callback' => 'absint',
                ),
                '_limit' => array(
                    'sanitize_callback' => 'absint',
                ),
                '_orderby' => array(
                    'validate_callback' => 'sanitize_text_field',
                ),
                '_order' => array(
                    'validate_callback' => 'sanitize_text_field',
                ),
            ),
        )
    );
}