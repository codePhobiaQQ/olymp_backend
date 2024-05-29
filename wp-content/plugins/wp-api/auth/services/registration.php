<?php

require_once plugin_dir_path(__FILE__) . '../emails-templates.php';

function registration($request) {
    $username = sanitize_email($request->get_param('username'));
    $password = $request->get_param('password');
    $role = $request->get_param('role') ?: 'subscriber';

    // Check params
    if (empty($username) || empty($password)) {
        return new WP_Error('invalid_data', 'Некорректный email или пароль', array('status' => 400));
    }

    // Check if user exists
    if (email_exists($username)) {
        return new WP_Error('user_exists', 'Пользователь с таким email уже существует', array('status' => 400));
    }

    // Check if role is valid
    $valid_roles = array('um_custom_role_1'); // Add more roles as needed
    if (!in_array($role, $valid_roles)) {
        return new WP_Error('invalid_role', 'Некорректная роль пользователя', array('status' => 400));
    }

    // Generate email approval key
    $approvalEmailId = wp_generate_password(20, false);

    // Send email
    $subject = 'V-Olymp Подтверждение аккаунта';
    $message = mailOptionsToAccessAccount(array(
        'to' => $username,
        'approvalEmailId' => $approvalEmailId
    ));
    $headers = array('Content-Type: text/html; charset=UTF-8');

    if (!wp_mail($username, $subject, $message['html'], $headers)) {
        return new WP_Error('email_failed', 'Ошибка при отправке письма', array('status' => 500));
    }

    // REGISTER USER
    $user_id = wp_create_user($username, $password, $username);
    if (is_wp_error($user_id)) {
        return $user_id;
    }

    // SET USER ROLE
    $user = new WP_User($user_id);
    $user->set_role($role);

    update_user_meta($user_id, 'acception_email_id', $approvalEmailId);
    update_user_meta($user_id, 'is_email_approved', 'false');

    // GENERATE JWT TOKEN
    $jwt_token = get_jwt_token($username, $password);

    return new WP_REST_Response(array('token' => $jwt_token), 200);
}

function get_jwt_token($username, $password) {
    $url = 'http://localhost:80/wp-json/jwt-auth/v1/token';

    $body = json_encode(array(
        'username' => $username,
        'password' => $password,
    ));

    $response = wp_remote_post($url, array(
        'method'    => 'POST',
        'headers'   => array('Content-Type' => 'application/json'),
        'body'      => $body,
        'data_format' => 'body',
    ));

    if (is_wp_error($response)) {
        return new WP_Error('request_failed', 'Не удалось выполнить запрос', array('status' => 500));
    }

    $response_code = wp_remote_retrieve_response_code($response);
    if ($response_code !== 200) {
        return new WP_Error('token_generation_failed', 'Не удалось сгенерировать JWT токен', array('status' => $response_code));
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if (isset($data['token'])) {
        return $data['token'];
    } else {
        return new WP_Error('token_generation_failed', 'Не удалось сгенерировать JWT токен', array('status' => 500));
    }
}