<?php
/**
 * Sistema de Views MVC
 * Analítica Soluções
 */

namespace App\Core;

use Exception;

class View {
    private $viewPath;
    private $data = [];

    public function __construct() {
        $this->viewPath = APP_PATH . '/Views/';
    }

    /**
     * Renderizar uma view
     */
    public function render($view, $data = []) {
        $this->data = array_merge($this->data, $data);

        // Extrair variáveis para o escopo da view
        extract($this->data);

        // Caminho completo da view
        $viewFile = $this->viewPath . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new Exception("View não encontrada: {$view}");
        }

        // Buffer de saída
        ob_start();
        include $viewFile;
        $content = ob_get_contents();
        ob_end_clean();

        echo $content;
    }

    /**
     * Renderizar view com layout
     */
    public function renderWithLayout($view, $data = [], $layout = 'layouts/main') {
        $this->data = array_merge($this->data, $data);

        // Renderizar conteúdo da view
        $content = $this->renderToString($view, $this->data);

        // Renderizar com layout
        $this->render($layout, array_merge($this->data, ['content' => $content]));
    }

    /**
     * Renderizar view para string (sem output)
     */
    public function renderToString($view, $data = []) {
        $viewData = array_merge($this->data, $data);
        extract($viewData);

        $viewFile = $this->viewPath . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new Exception("View não encontrada: {$view}");
        }

        ob_start();
        include $viewFile;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }

    /**
     * Incluir componente
     */
    public function component($component, $data = []) {
        $componentData = array_merge($this->data, $data);
        extract($componentData);

        $componentFile = $this->viewPath . 'components/' . $component . '.php';

        if (file_exists($componentFile)) {
            include $componentFile;
        }
    }

    /**
     * Incluir partial
     */
    public function partial($partial, $data = []) {
        $partialData = array_merge($this->data, $data);
        extract($partialData);

        $partialFile = $this->viewPath . 'partials/' . $partial . '.php';

        if (file_exists($partialFile)) {
            include $partialFile;
        }
    }

    /**
     * Escapar conteúdo HTML
     */
    public function escape($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Verificar se view existe
     */
    public function exists($view) {
        return file_exists($this->viewPath . $view . '.php');
    }

    /**
     * Adicionar dados globais à view
     */
    public function share($key, $value = null) {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }
    }

    /**
     * Obter dados da view
     */
    public function getData() {
        return $this->data;
    }

    /**
     * Limpar dados da view
     */
    public function clearData() {
        $this->data = [];
    }
}

// Funções auxiliares globais para views
if (!function_exists('e')) {
    function e($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('old')) {
    function old($key, $default = '') {
        return $_SESSION['old'][$key] ?? $default;
    }
}