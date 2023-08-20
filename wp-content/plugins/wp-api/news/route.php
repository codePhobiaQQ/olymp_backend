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
                    'validate_callback' => 'is_numeric',
                ),
                '_limit' => array(
                    'validate_callback' => 'is_numeric',
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