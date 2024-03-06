<?php

function login($params)
{
    $login = absint($params->get_param('login'));
    $password = absint($params->get_param('password'));
    return [$login, $password];
}