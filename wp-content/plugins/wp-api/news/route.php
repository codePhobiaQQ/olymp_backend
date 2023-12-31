<?php

require_once plugin_dir_path(__FILE__) . 'services/getNews.php';
require_once plugin_dir_path(__FILE__) . 'services/getCategories.php';

function registerNewsEndpoints() {
    // Get News
    register_rest_route(
        'custom/v2',
        '/news',

        array(
            'methods' => 'GET',

            'callback' => 'getNews',
            'permission_callback' => '__return_true',  

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
                '_order' => array(
                    'validate_callback' => 'sanitize_text_field',
                ),
                'categories' => array(
                    'sanitize_callback' => 'sanitize_text_field',
                ),
            ),
        )
    );

    // Get News categories
    register_rest_route(
        'custom/v2',
        '/news/categories',

        array(
            'methods' => 'GET',
            'callback' => 'getCategories',
            'permission_callback' => '__return_true',  
            'orderby' => 'post_date',
            'order' => 'DESC',
        )
    );
}