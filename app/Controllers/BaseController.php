<?php
/**
 * Controlador Base
 * Analítica Soluções - Sistema MVC
 */

namespace App\Controllers;

use App\Core\Router;
use App\Core\View;
use Exception;

class BaseController {
    protected $view;
    protected $router;
    
    public function __construct() {
        $this->view = new View();
        $this->router = new Router();
        $this->init();
    }
    
    /**
     * Inicialização do controlador
     */
    protected function init() {
        // Iniciar sessão se necessário
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Dados globais para todas as views
        $this->view->share([
            'router' => $this->router,
            'currentRoute' => $this->getCurrentRoute(),
            'siteUrl' => APP_URL,
            'siteName' => APP_NAME,
            'year' => date('Y'),
            'statusMessage' => $this->getStatusMessage()
        ]);
    }
    
    /**
     * Obter rota atual
     */
    protected function getCurrentRoute() {
        return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Renderizar view com layout
     */
    protected function render($view, $data = []) {
        $routeInfo = $this->router->getCurrentRouteInfo();
        
        $defaultData = [
            'title' => $routeInfo['title'],
            'description' => $routeInfo['description'],
            'canonical' => $this->router->getCanonicalUrl(),
            'activeSection' => $routeInfo['section']
        ];
        
        $viewData = array_merge($defaultData, $data);
        $this->view->renderWithLayout($view, $viewData);
    }
    
    /**
     * Renderizar apenas a view (sem layout)
     */
    protected function renderView($view, $data = []) {
        $this->view->render($view, $data);
    }
    
    /**
     * Redirect para URL
     */
    protected function redirect($url, $statusCode = 302) {
        if (ob_get_level()) {
            ob_end_clean();
        }
        
        header("Location: $url", true, $statusCode);
        exit;
    }
    
    /**
     * Redirect com mensagem
     */
    protected function redirectWithMessage($url, $message, $type = 'success') {
        $_SESSION['flash_message'] = [
            'message' => $message,
            'type' => $type
        ];
        
        $this->redirect($url);
    }
    
    /**
     * Obter mensagens de status/flash
     */
    protected function getStatusMessage() {
        $message = null;
        
        // Mensagem via GET (para compatibilidade)
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
            $msg = $_GET['message'] ?? '';
            
            switch ($status) {
                case 'success':
                    $message = [
                        'type' => 'success',
                        'message' => 'Mensagem enviada com sucesso! Entraremos em contato em breve.'
                    ];
                    break;
                case 'error':
                    $message = [
                        'type' => 'error', 
                        'message' => $msg ?: 'Ocorreu um erro. Tente novamente.'
                    ];
                    break;
            }
        }
        
        // Mensagem via sessão (flash message)
        if (isset($_SESSION['flash_message'])) {
            $message = $_SESSION['flash_message'];
            unset($_SESSION['flash_message']);
        }
        
        return $message;
    }
    
    /**
     * Validar token CSRF
     */
    protected function validateCSRF($token) {
        if (!isset($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            throw new Exception('Token CSRF inválido');
        }
    }
    
    /**
     * Gerar token CSRF
     */
    protected function generateCSRF() {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        
        return $_SESSION['csrf_token'];
    }
    
    /**
     * Validar dados de entrada
     */
    protected function validate($data, $rules) {
        $errors = [];
        
        foreach ($rules as $field => $fieldRules) {
            $value = $data[$field] ?? null;
            $rulesArray = explode('|', $fieldRules);
            
            foreach ($rulesArray as $rule) {
                $error = $this->validateRule($field, $value, $rule);
                if ($error) {
                    $errors[$field] = $error;
                    break; // Parar na primeira regra que falhar
                }
            }
        }
        
        return $errors;
    }
    
    /**
     * Validar regra específica
     */
    private function validateRule($field, $value, $rule) {
        switch ($rule) {
            case 'required':
                return empty($value) ? "O campo {$field} é obrigatório" : null;
                
            case 'email':
                return !filter_var($value, FILTER_VALIDATE_EMAIL) ? "O campo {$field} deve ser um email válido" : null;
                
            case 'min:3':
                return strlen($value) < 3 ? "O campo {$field} deve ter pelo menos 3 caracteres" : null;
                
            default:
                return null;
        }
    }
    
    /**
     * Sanitizar dados de entrada
     */
    protected function sanitize($data) {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    /**
     * Resposta JSON
     */
    protected function jsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
    
    /**
     * Obter IP do cliente
     */
    protected function getClientIP() {
        $ipKeys = ['HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'REMOTE_ADDR'];
        
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip);
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        
        return $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    }
}