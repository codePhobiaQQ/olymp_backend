<?php
/**
 * Plugin Name: Custom API
 * Plugin URI: http://chrushingit.com
 * Description: Custom API for olymp website
 * Version: 1.1
 * Author: Vitali Peregudov
 * Author URI: http://watch-learn.com
 */

require_once plugin_dir_path(__FILE__) . 'news/route.php';
require_once plugin_dir_path(__FILE__) . 'olymps/route.php';
require_once plugin_dir_path(__FILE__) . 'lk/route.php';

add_action('rest_api_init', function() {
    registerNewsEndpoints();
    regOlympsEndpoints();
    lkEndpoints();
});