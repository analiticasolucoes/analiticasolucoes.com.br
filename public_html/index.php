<?php
/**
 * Front Controller - Ponto de entrada único da aplicação
 * Analítica Soluções - Sistema MVC
 */

// Inicializar sistema de roteamento
try {
    require_once dirname(__DIR__) .
            DIRECTORY_SEPARATOR . 'vendor' .
            DIRECTORY_SEPARATOR . 'autoload.php';

    // Definir constantes do sistema
    define('ROOT_PATH', dirname(__DIR__, 1));
    define('APP_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'app');
    define('PUBLIC_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'public_html');
    define('CONFIG_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'config');
    define('STORAGE_PATH', ROOT_PATH . DIRECTORY_SEPARATOR . 'storage');

    // Carregar configurações
    require_once CONFIG_PATH . DIRECTORY_SEPARATOR . 'app.php';

    $router = new App\Core\Router();
    $router->dispatch();
} catch (Exception $e) {
    // Log do erro
    error_log('Front Controller Error: ' . $e->getMessage());
    
    // Mostrar página de erro
    http_response_code(500);
    if (defined('APP_DEBUG') && APP_DEBUG) {
        echo '<h1>Erro no Sistema</h1>';
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<pre>' . $e->getTraceAsString() . '</pre>';
    } else {
        require_once APP_PATH . '/Views/pages/500.php';
    }
}