<?php

class WPPosts extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->posts,
            'as' => 'posts',
            'cols' => array(
                'ID',
                'post_author',
                'post_date',
                'post_content',
                'post_title',
                'post_excerpt',
                'post_status',
                'post_name',
                'post_modified',
                'post_parent',
                'guid',
                'post_type',
                'post_mime_type',
                'comment_count'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPPostmeta extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->postmeta,
            'as' => 'postmeta',
            'cols' => array(
                'meta_id',
                'post_id',
                'meta_key',
                'meta_value'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPComments extends Rcl_Query {
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->comments,
            'as' => 'comments',
            'cols' => array(
                'comment_ID',
                'comment_post_ID',
                'comment_author',
                'comment_author_email',
                'comment_author_url',
                'comment_author_IP',
                'comment_date',
                'comment_content',
                'comment_approved',
                'comment_agent',
                'comment_type',
                'comment_parent',
                'user_id'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPCommentmeta extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->commentmeta,
            'as' => 'commentmeta',
            'cols' => array(
                'meta_id',
                'comment_id',
                'meta_key',
                'meta_value'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPUsers extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->users,
            'as' => 'users',
            'cols' => array(
                'ID',
                'user_login',
                'user_nicename',
                'user_email',
                'user_url',
                'user_registered',
                'user_status',
                'display_name'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPUsermeta extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->usermeta,
            'as' => 'usermeta',
            'cols' => array(
                'umeta_id',
                'user_id',
                'meta_key',
                'meta_value'
            )
        );
        
        parent::__construct($table);
        
    }

}

class WPOptions extends Rcl_Query {
    
    function __construct() {
        global $wpdb;

        $table = array(
            'name' => $wpdb->options,
            'as' => 'options',
            'cols' => array(
                'option_id',
                'option_name',
                'option_value',
                'autoload'
            )
        );
        
        parent::__construct($table);
        
    }

}