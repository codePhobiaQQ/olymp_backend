<?php

//include_once(__DIR__ . '/wp-recall/add-on/rest-api/classes/class-rest-api.php');
//include_once(__DIR__ . '/../route.php');

// include_once(__DIR__ . '/../../../wp-recall/classes/query/class-rcl-query.php');

//class CustomQuery extends Rcl_Query
//{
//    function __construct()
//    {
//        $table = array(
//            'name' => 'wp_users',
//            'as' => 'custom',
//
//            'cols' => array(
//                'ID',
//                'user_login',
//                'user_pass',
//                'user_nicename',
//                'user_email',
//                'user_url',
//                'user_registered',
//                'user_activation_key',
//                'user_status',
//                'display_nam',
//            )
//        );
//        parent::__construct($table);
//    }
//}

function test()
{

    return 'hello';
//    $Query = new CustomQuery();
//    return $Query->get_results(array(
//        'user_login__in' => array(10,25),
//        'col_value' => 'any',
//        'fields' => array(
//            'col_id',
//            'col_date'
//        ),
//        'number' => 5,
//        'orderby' => 'col_date',
//        'order' => 'ASC'
//    ));
}