<?php

function login($params) {
    $email = absint($params->get_param('email'));
    $password = absint($params->get_param('password'));

    $roles = get_editable_roles();
//    echo $roles;
//    foreach ( $roles as $role_id => $role_info ) {
//        echo 'Role: ' . $role_info['name'] . '<br>';
//    }

    return [$email, $password];
}