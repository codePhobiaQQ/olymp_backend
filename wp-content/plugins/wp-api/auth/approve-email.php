<?php

function mailOptionsToAccessAccount($args) {
    $to = $args['to'];
    $approvalEmailId = $args['approvalEmailId'];
    $message = "
    <div style='display: flex; flex-direction: column; gap: 8px'>
        <p>Чтобы подтвердить ваш аккаунт перейдите <a href='http://localhost:5173/user-email-acception?email=$to&id=$approvalEmailId' target='_blank'>по ссылке</a></p>
        <p>Это письмо не требует ответа, оно нужно для подтверждения e-mail вашего аккаунта</p>
    </div>";

    return array(
        'html' => $message
    );
}