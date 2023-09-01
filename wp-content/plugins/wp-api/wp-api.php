<?php
/**
 * Plugin Name: Custom API
 * Plugin URI: http://chrushingit.com
 * Description: Custom API for olymp website
 * Version: 1.1
 * Author: Vitali Peregudov
 * Author URI: http://watch-learn.com
 */

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

require_once plugin_dir_path(__FILE__) . 'news/route.php';

// function get_image_by_id($request) {
//     $attachment_id = $request['id'];
    
//     $image_data = array();
    
//     if ($attachment_id && wp_attachment_is_image($attachment_id)) {
//         $image_src = wp_get_attachment_image_src($attachment_id, 'full');
        
//         if ($image_src) {
//             $image_data['id'] = $attachment_id;
//             $image_data['url'] = $image_src[0];
//         }
//     }
    
//     return rest_ensure_response($image_data);
// }

add_action('rest_api_init', function() {
	// register_rest_route(
	// 	'custom/v2',   // Namespace for your endpoint
	// 	'/image/(?P<id>\d+)',   // Endpoint path with a parameter named "id"
	// 	array(
    //         'methods' => 'GET',
    //         'callback' => 'get_image_by_id',
    //         'permission_callback' => '__return_true', // Allow any user to access
	// 	)
    // );

    registerNewsEndpoints();
});