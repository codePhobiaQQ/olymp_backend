<?php

function login($params)
{
    $login = absint($params->get_param('login'));

    echo $login;
}