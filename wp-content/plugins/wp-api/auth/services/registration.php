<?php

function registration($params) {
    $email = $params->get_param('email');
    $password = $params->get_param('password');

    // Создание пользователя
    $user_id = wp_create_user($email, $password, $email);

    if ( is_wp_error( $user_id ) ) {
        echo $user_id->get_error_message();
    }
    else {
        echo 'User is done';
    }
}