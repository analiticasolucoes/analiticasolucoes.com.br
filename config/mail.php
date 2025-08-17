<?php
/**
 * Configurações de Email
 * Analítica Soluções - Sistema MVC
 */

// Configurações SMTP
define('MAIL_HOST', 'localhost');
define('MAIL_PORT', 587);
define('MAIL_USERNAME', '');
define('MAIL_PASSWORD', '');
define('MAIL_ENCRYPTION', 'tls'); // 'tls' ou 'ssl'

// Configurações de remetente
define('MAIL_FROM_ADDRESS', 'noreply@analiticasolucoes.com.br');
define('MAIL_FROM_NAME', 'Analítica Soluções');

// Email de destino para formulários
define('CONTACT_EMAIL', SITE_CONTACT_EMAIL);

// Configurações de template
define('MAIL_TEMPLATE_PATH', APP_PATH . '/Views/emails/');

// Função para enviar email
function sendMail($to, $subject, $message, $headers = []) {
    $defaultHeaders = [
        'From: ' . MAIL_FROM_NAME . ' <' . MAIL_FROM_ADDRESS . '>',
        'Reply-To: ' . $to,
        'X-Mailer: PHP/' . phpversion(),
        'Content-Type: text/plain; charset=UTF-8',
        'MIME-Version: 1.0'
    ];

    $allHeaders = array_merge($defaultHeaders, $headers);

    $success = mail($to, $subject, $message, implode("\r\n", $allHeaders));

    // Log do envio
    $status = $success ? 'success' : 'failed';
    writeLog("Email {$status}: {$subject} to {$to}", 'mail');

    return $success;
}

// Função para validar email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}