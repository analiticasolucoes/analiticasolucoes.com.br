<?php
/**
 * Sistema de Roteamento MVC
 * Analítica Soluções
 */

namespace App\Core;

use App\Core\View;
use Exception;

class Router {
    private $routes = [];
    private $currentUri;
    private $currentMethod;
    private $defaultControllerNameSpace = 'App\\Controllers\\';

    public function __construct($controllerNameSpace = null) {
        if($controllerNameSpace) {
            $this->defaultControllerNameSpace = $controllerNameSpace;
        }
        $this->currentUri = $this->getCurrentUri();
        $this->currentMethod = $_SERVER['REQUEST_METHOD'];
        $this->setupRoutes();
    }

    /**
     * Configurar rotas da aplicação
     */
    private function setupRoutes() {
        // Rotas GET
        $this->get('/', 'HomeController@index');
        $this->get('/solucoes', 'HomeController@solucoes');
        $this->get('/sobre', 'HomeController@sobre');
        $this->get('/avaliacoes', 'HomeController@avaliacoes');
        $this->get('/portifolio', 'HomeController@portifolio');
        $this->get('/contato', 'HomeController@contato');

        // Rotas POST
        $this->post('/contato', 'ContactController@store');

        // Rota para API (futuro)
        $this->get('/api/sitemap', 'ApiController@sitemap');
    }

    /**
     * Obter URI atual limpa
     */
    private function getCurrentUri() {
        $uri = $_SERVER['REQUEST_URI'];
        $path = parse_url($uri, PHP_URL_PATH);

        // Remover trailing slash exceto para home
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        return $path;
    }

    /**
     * Adicionar rota GET
     */
    public function get($uri, $action) {
        $this->addRoute('GET', $uri, $action);
    }

    /**
     * Adicionar rota POST
     */
    public function post($uri, $action) {
        $this->addRoute('POST', $uri, $action);
    }

    /**
     * Adicionar rota ao sistema
     */
    private function addRoute($method, $uri, $action) {
        $this->routes[$method][$uri] = $action;
    }

    /**
     * Despachar requisição para controller apropriado
     */
    public function dispatch() {
        // Verificar se existe rota para o método atual
        if (!isset($this->routes[$this->currentMethod])) {
            $this->handle404();
            return;
        }

        $routes = $this->routes[$this->currentMethod];

        // Verificar rota exata
        if (isset($routes[$this->currentUri])) {
            $this->callAction($routes[$this->currentUri]);
            return;
        }

        // Verificar rotas com parâmetros (para futuras implementações)
        foreach ($routes as $route => $action) {
            if ($this->matchRoute($route, $this->currentUri)) {
                $this->callAction($action);
                return;
            }
        }

        // Nenhuma rota encontrada
        $this->handle404();
    }

    /**
     * Verificar correspondência de rota com parâmetros
     */
    private function matchRoute($route, $uri) {
        // Converter rota em regex (para futuras implementações com parâmetros)
        $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_-]+)', $route);
        $pattern = '#^' . $pattern . '$#';

        return preg_match($pattern, $uri);
    }

    /**
     * Chamar ação do controller
     */
    private function callAction($action) {
        list($controllerName, $methodName) = explode('@', $action);

        $controllerClass = $this->defaultControllerNameSpace . $controllerName;
        
        // Verificar se controller existe
        if (!class_exists($controllerClass)) {
            throw new Exception("Controller {$controllerName} não encontrado");
        }

        $controller = new $controllerClass();

        // Verificar se método existe
        if (!method_exists($controller, $methodName)) {
            throw new Exception("Método {$methodName} não encontrado no controller {$controllerName}");
        }

        // Chamar método do controller
        $controller->$methodName();
    }

    /**
     * Lidar com página não encontrada (404)
     */
    private function handle404() {
        http_response_code(404);

        // Log da tentativa de acesso
        writeLog("404 - Página não encontrada: {$this->currentUri}", 'access');

        // Renderizar página 404
        $view = new View();
        $view->render('pages/404', [
            'title' => 'Página não encontrada - ' . APP_NAME,
            'currentUri' => $this->currentUri
        ]);
    }

    /**
     * Obter informações da rota atual (para SEO)
     */
    public function getCurrentRouteInfo() {
        $routeInfo = [
            '/' => [
                'title' => DEFAULT_TITLE,
                'description' => DEFAULT_DESCRIPTION,
                'section' => 'home'
            ],
            '/solucoes' => [
                'title' => 'Nossas Soluções - ' . APP_NAME,
                'description' => 'Conheça as soluções em desenvolvimento web, SEO, gestão de conteúdo e mais da Analítica Soluções',
                'section' => 'solucoes'
            ],
            '/sobre' => [
                'title' => 'Sobre Nós - ' . APP_NAME,
                'description' => 'Conheça a Analítica Soluções, empresa capixaba especializada em desenvolvimento web e soluções digitais',
                'section' => 'sobre'
            ],
            '/avaliacoes' => [
                'title' => 'Avaliações dos Clientes - ' . APP_NAME,
                'description' => 'Veja as avaliações e depoimentos dos nossos clientes satisfeitos',
                'section' => 'avaliacoes'
            ],
            '/portifolio' => [
                'title' => 'Portfólio - ' . APP_NAME,
                'description' => 'Conheça alguns dos projetos desenvolvidos pela Analítica Soluções',
                'section' => 'portifolio'
            ],
            '/contato' => [
                'title' => 'Contato - ' . APP_NAME,
                'description' => 'Entre em contato com a Analítica Soluções e solicite seu orçamento personalizado',
                'section' => 'contato'
            ]
        ];

        return $routeInfo[$this->currentUri] ?? $routeInfo['/'];
    }

    /**
     * Verificar se seção está ativa
     */
    public function isActiveSection($section) {
        $routeInfo = $this->getCurrentRouteInfo();
        return $routeInfo['section'] === $section;
    }

    /**
     * Gerar URL canônica
     */
    public function getCanonicalUrl() {
        return APP_URL . ($this->currentUri === '/' ? '' : $this->currentUri);
    }
}