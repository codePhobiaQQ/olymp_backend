<?php

add_action( 'init', 'rcl_rest_set_rewrite' );
function rcl_rest_set_rewrite() {
    add_rewrite_tag( '%api_action%', '([^/]+)' );
    add_rewrite_tag( '%api_table%', '([^/]+)' );

    add_rewrite_rule( 'rcl_api/?$', 'index.php?pagename=rcl_api', 'top' );
    add_rewrite_rule( 'rcl_api/([^/]+)/?$', 'index.php?pagename=rcl_api&api_action=$matches[1]', 'top' );
    add_rewrite_rule( 'rcl_api/([^/]+)/([^/]+)/?$', 'index.php?pagename=rcl_api&api_action=$matches[1]&api_table=$matches[2]', 'top' );
}

add_action( 'template_redirect', 'rcl_rest_theme_redirect' );
function rcl_rest_theme_redirect() {

    global $wp;

    if(!isset( $wp->query_vars["pagename"] ) || $wp->query_vars["pagename"] != "rcl_api") return false;
    
    $tables = apply_filters('rcl_rest_tables', array(
        'posts' => 'WPPosts',
        'postmeta' => 'WPPostmeta',
        'comments' => 'WPComments',
        'commentmeta' => 'WPCommentmeta',
        'users' => 'WPUsers',
        'usermeta' => 'WPUsermeta'
    ));
    
    if(!$tables){
        wp_send_json(array(
            'error' => __('Запросы ко всем таблицам запрещены.')
        ));
    }

    if ( 
        isset( $wp->query_vars["api_action"] ) && ($wp->query_vars["api_table"] == 'multiple' || isset( $tables[$wp->query_vars["api_table"]]) )
    ) {
        
        do_action('rcl_rest_pre_request');
        
        $action = $wp->query_vars["api_action"];
        
        require_once 'classes/query-default-tables.php';
        require_once 'classes/class-rest-api.php';

        $API = new RCL_REST_API($tables);

        switch($action){
            case 'get': 
                
                $cachekey = json_encode(array($wp->query_vars["api_table"],$_GET));
                
                $cache = new Rcl_Cache();

                $file = $cache->get_file($cachekey);

                if(!$file->need_update && $file->file_exists){

                    $response = file_get_contents($file->filepath);

                }
                
                if ( !$response ){

                    $response = wp_json_encode($API->get($wp->query_vars["api_table"],$_GET));

                    rcl_cache_add($cachekey, $response, true);
                
                }
                
                break;
        }
        
        @header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
        
	if ( null !== $status_code ) {
            status_header( $status_code );
	}
        
	echo $response;

	if ( wp_doing_ajax() ) {
            wp_die( '', '', array(
                'response' => null,
            ) );
	} else {
            die;
	}
        
    }else{
        wp_send_json(array(
            'error' => __('Адрес запроса неверен.')
        ));
    }
}

