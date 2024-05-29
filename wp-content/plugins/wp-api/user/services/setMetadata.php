<?php

function setMetadata(WP_REST_Request $request) {
   $current_user = wp_get_current_user();
   $required_fields = array('first_name', 'second_name', 'patronymic', 'school', 'grade');

   // CHECK DATA
   foreach ($required_fields as $field) {
       if (empty($request->get_param($field))) {
           return new WP_Error('missing_field', sprintf('Пожалуйста заполните данные %s', $field), array('status' => 400));
       }
   }

   // CHECK USER APPROVAL E-MAIL
   $isApproval = get_user_meta($current_user->ID, 'is_email_approved', true);
   print_r($isApproval);

   if ($isApproval !== 'true') {
       return new WP_Error('email_not_approved', 'Ваш e-mail не подтвержден', array('status' => 400));
   }

   // UPDATE METADATA
   foreach ($required_fields as $field) {
       update_user_meta($current_user->ID, $field, sanitize_text_field($request->get_param($field)));
   }

   return new WP_REST_Response(array(
       'message' => 'Данные для прохождения проверочного этапа успешно заполнены'
   ), 200);
}