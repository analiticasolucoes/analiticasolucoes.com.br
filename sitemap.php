<?php
/**
 * Gerador de Sitemap XML - Sistema MVC
 * Analítica Soluções
 */

// Definir constantes básicas se não estiverem definidas
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', __DIR__);
    define('APP_PATH', ROOT_PATH . '/app');
    define('CONFIG_PATH', ROOT_PATH . '/config');
}

// Carregar configurações
require_once CONFIG_PATH . '/app.php';

// Autoloader simples para o sitemap
spl_autoload_register(function ($className) {
    $file = APP_PATH . '/Models/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Header XML
header('Content-Type: application/xml; charset=utf-8');

// Obter URLs do modelo Page
try {
    $urls = Page::getSitemapUrls();
} catch (Exception $e) {
    // Fallback caso o modelo não funcione
    $urls = [
        [
            'loc' => APP_URL . '/',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '1.0'
        ],
        [
            'loc' => APP_URL . '/solucoes',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'loc' => APP_URL . '/sobre',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ],
        [
            'loc' => APP_URL . '/avaliacoes',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'weekly',
            'priority' => '0.6'
        ],
        [
            'loc' => APP_URL . '/portifolio',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.8'
        ],
        [
            'loc' => APP_URL . '/contato',
            'lastmod' => date('Y-m-d'),
            'changefreq' => 'monthly',
            'priority' => '0.7'
        ]
    ];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= htmlspecialchars($url['loc']) ?></loc>
        <lastmod><?= $url['lastmod'] ?></lastmod>
        <changefreq><?= $url['changefreq'] ?></changefreq>
        <priority><?= $url['priority'] ?></priority>
    </url>
<?php endforeach; ?>
</urlset>