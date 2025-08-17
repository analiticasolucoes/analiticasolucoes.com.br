<?php
/**
 * Configurações da Aplicação
 * Analítica Soluções - Sistema MVC
 */

// Configurações de ambiente
define('APP_ENV', 'development'); // 'development' ou 'production'
define('APP_DEBUG', APP_ENV === 'development');
define('APP_NAME', 'Analítica Soluções');
define('APP_URL', 'https://analiticasolucoes.com.br');
define('APP_VERSION', '2.0.0');

// Configurações de erro
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', STORAGE_PATH . '/logs/php_errors.log');
}

// Configurações de charset e timezone
date_default_timezone_set('America/Sao_Paulo');
ini_set('default_charset', 'UTF-8');
mb_internal_encoding('UTF-8');

// Configurações de sessão
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_samesite', 'Strict');

// Configurações do site
define('SITE_CONTACT_EMAIL', 'contato@analiticasolucoes.com.br');
define('SITE_PHONE', '+55 27 98882-6711');
define('SITE_WHATSAPP', '5527988826711');

// Configurações de cache
define('CACHE_ENABLED', !APP_DEBUG);
define('CACHE_DURATION', 3600); // 1 hora

// Configurações de SEO
define('DEFAULT_TITLE', 'Analítica Soluções - Desenvolvimento de Sistemas e Webdesign');
define('DEFAULT_DESCRIPTION', 'Desenvolvimento de Sistemas e Webdesign | Analítica Soluções - Soluções Digitais Inovadoras');
define('DEFAULT_KEYWORDS', 'desenvolvimento web, sistemas, webdesign, seo, marketing digital, espírito santo');

// Configurações de redes sociais
define('FACEBOOK_URL', 'https://www.facebook.com/profile.php?id=61550039357070');
define('INSTAGRAM_URL', 'https://www.instagram.com/analiticasolucoes.es/');
define('GOOGLE_BUSINESS_URL', 'https://goo.gl/maps/E3VvBtVBFYHGXzhW9');

// Configurações do Google Analytics
define('GA_TRACKING_ID', 'G-FQXCK1DLX1');
define('GOOGLE_ADS_ID', 'AW-11285759604');

// Configurações de upload (para futuras funcionalidades)
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5MB
define('ALLOWED_EXTENSIONS', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'pdf']);

// Função para obter configuração
function config($key, $default = null) {
    return defined($key) ? constant($key) : $default;
}

// Função para asset URL
function asset($path) {
    return APP_URL . '/public/assets/' . ltrim($path, '/');
}

// Função para URL da aplicação
function url($path = '') {
    return APP_URL . '/' . ltrim($path, '/');
}

// Função de debug
function dump($data) {
    if (APP_DEBUG) {
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }
}

function dd($data) {
    dump($data);
    die();
}

// Função de log
function writeLog($message, $type = 'info') {
    $logDir = STORAGE_PATH . '/logs/';
    if (!is_dir($logDir)) {
        mkdir($logDir, 0755, true);
    }
    
    $timestamp = date('Y-m-d H:i:s');
    $logMessage = "[{$timestamp}] [{$type}] {$message}" . PHP_EOL;
    
    file_put_contents($logDir . 'app.log', $logMessage, FILE_APPEND | LOCK_EX);
}

// Carregar outras configurações
require_once CONFIG_PATH . '/mail.php';