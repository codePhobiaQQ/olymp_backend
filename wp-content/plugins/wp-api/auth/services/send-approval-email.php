<?php

require_once plugin_dir_path(__FILE__) . '../emails-templates.php';

function send_approval_email(WP_REST_Request $request) {
    $username = sanitize_email($request->get_param('email'));

    // Check if user exists
    $user = get_user_by('email', $username);

    if (!$user) {
        return new WP_Error('user_not_found', 'Пользователя с таким email не существует', array('status' => 400));
    }

    $user_id = $user->ID;

    // Check if email is already approved
    $is_approved = get_user_meta($user_id, 'is_email_approved', true);

    if ($is_approved === 'true') {
        return new WP_Error('email_already_approved', 'У данного пользователя уже подтвержден e-mail', array('status' => 400));
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

    // Save the approval email ID as user meta
    update_user_meta($user_id, 'acception_email_id', $approvalEmailId);

    return new WP_REST_Response(array('message' => 'Письмо было отправлено!'), 200);
}