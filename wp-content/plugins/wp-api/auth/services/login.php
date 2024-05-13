<?php

function login($params) {
    $email = $params->get_param('email');
    $password = $params->get_param('password');

    // Попытка аутентификации пользователя
    $user = wp_authenticate( $email, $password );

    if ( is_wp_error( $user ) ) {
        // Ошибка аутентификации
        echo $user->get_error_message();
    } else {
        // Успешная аутентификация
        $user_id = $user->data->ID;

        // Получаем объект пользователя с его ролью
        $user_data = get_userdata($user_id);

        // Добавляем данные о статусе подтверждения email и роли в массив $user->data
        $user->is_email_approved = get_user_meta($user_id, 'is_email_approved', true);
        $user->role = $user_data->roles[0]; // Берем первую роль пользователя

        // Возвращаем информацию о пользователе
        return $user;
    }
}