<?php

require_once plugin_dir_path(__FILE__) . '../approve-email.php';

function approve_email(WP_REST_Request $request) {
    $email = sanitize_email($request->get_param('email'));
        $acception_email_id = sanitize_text_field($request->get_param('acception_email_id'));

        if (empty($email) || empty($acception_email_id)) {
            return new WP_Error('invalid_data', 'Invalid email or acception email ID', array('status' => 400));
        }

        // Fetch the user by email
        $user = get_user_by('email', $email);

        if (!$user) {
            return new WP_Error('user_not_found', 'User not found', array('status' => 400));
        }

        $user_id = $user->ID;

        // Fetch the acception email ID from user meta
        $real_user_approve_email_id = get_user_meta($user_id, 'acception_email_id', true);

        if (empty($real_user_approve_email_id)) {
            return new WP_Error('invalid_request', 'Email approval request is invalid', array('status' => 400));
        }

        // Validate the provided acception email ID
        if ($acception_email_id !== $real_user_approve_email_id) {
            return new WP_Error('invalid_link', 'The email approval link is invalid', array('status' => 400));
        }

        // Update the email approval status
        update_user_meta($user_id, 'is_email_approved', 'true');

        // Remove the acception email ID from user meta
        delete_user_meta($user_id, 'acception_email_id');

        return new WP_REST_Response(array('message' => 'ok'), 200);
}

