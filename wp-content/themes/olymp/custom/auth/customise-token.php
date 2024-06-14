<?php

function customize_token( $token, $user ) {
    // Массив сопоставления ролей WordPress и заданных ролей
    $roles_mapping = array(
        "um_custom_role_1" => "teenager",
        "admin" => "admin"
    );

    // Получаем первую роль пользователя, если она существует
    $user_role = isset($user->roles) && is_array($user->roles) ? reset($user->roles) : null;

    // Проверяем, существует ли сопоставленная роль для данной роли пользователя
    if ($user_role && isset($roles_mapping[$user_role])) {
        // Если сопоставленная роль существует, добавляем её в токен
        $token['data']['user']['role'] = $roles_mapping[$user_role];
    } else {
        // Если сопоставленная роль не найдена или роль пользователя не существует, добавляем роль пользователя WordPress
        $token['data']['user']['role'] = $user_role;
    }

    // Добавляем дополнительное поле в токен (например, isEmailApprove)
    $token['data']['user']['isApproval'] = $user->is_email_approved;

    // Добавляем email пользователя в токен
    $token['data']['user']['email'] = $user->user_email;

    // Возвращаем измененный токен
    return $token;
}

function customize_token_response( $data, $user ) {
    // Оставляем только токен в ответе
    return array(
        'token' => $data['token']
    );
}