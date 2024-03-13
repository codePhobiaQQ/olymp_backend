<?php

function registration($params) {
    $email = $params->get_param('email');
    $password = $params->get_param('password');

    // Создание пользователя
    $user_id = wp_create_user($email, $password, $email);

    if ( is_wp_error( $user_id ) ) {
        echo $user_id->get_error_message();
    } else {
        // Обновление статуса пользователя
        $userdata = array(
            'ID' => $user_id,
            'role' => 'um_custom_role_1',
        );

        update_user_meta( $user_id, 'is_email_approved', 'false' );
        $updated_user = wp_update_user( $userdata );

        if ( is_wp_error( $updated_user ) ) {
            echo $updated_user->get_error_message();
        } else {
            echo 'User is done';
        }
    }
}
