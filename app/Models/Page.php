<?php
/**
 * Modelo de Página
 * Analítica Soluções - Sistema MVC
 */

class Page extends BaseModel {
    
    /**
     * Obter dados das soluções
     */
    public static function getSolutions() {
        return [
            [
                'title' => 'Páginas<br>Dinâmicas',
                'image' => 'paginas-dinamicas.webp',
                'alt' => 'ícone representando páginas dinâmicas',
                'description' => 'Criação de <strong>páginas dinâmicas</strong> com foco em micro, pequenas empresas e prestadores de serviços.'
            ],
            [
                'title' => 'Gestão de<br>conteúdo',
                'image' => 'gestao-conteudo.webp',
                'alt' => 'ícone representando gestão de conteúdo',
                'description' => 'Garantimos que o <strong>conteúdo</strong> do seu site esteja <strong>atualizado e relevante</strong>.'
            ],
            [
                'title' => 'SEO - Search<br>Engine Optimization',
                'image' => 'seo-otimizacao.webp',
                'alt' => 'ícone representando otimização de SEO',
                'description' => 'Criação e acompanhamento de <strong>estratégias para otimização de resultados</strong> nos mecanismos de buscas.'
            ],
            [
                'title' => 'Captação de<br>Leads',
                'image' => 'captura-leads.webp',
                'alt' => 'ícone representando captação de leads',
                'description' => '<strong>Conquista de novos clientes</strong> para o seu negócio por meio de técnicas de gestão de tráfego (Tráfego Orgânico e Tráfego Pago).'
            ],
            [
                'title' => 'Redes<br>Sociais',
                'image' => 'integracao-redes-sociais.webp',
                'alt' => 'ícone representando integração com redes sociais',
                'description' => '<strong>Integração entre sua página e seus perfis nas redes sociais</strong> (Instagram, Facebook, Google Empresas, etc.) com geração de conteúdo dinâmico.'
            ]
        ];
    }
    
    /**
     * Obter dados das avaliações
     */
    public static function getReviews() {
        return [
            [
                'name' => 'Di Lameti Express',
                'date' => 'Um mês atrás',
                'rating' => 5,
                'content' => 'Qualidade e profissionalismo define bem a Analítica Soluções. Uma parceria de sucesso.',
                'image' => 'https://lh3.googleusercontent.com/a-/ALV-UjWkU7acPalJpg_ZfsExVzci1dwKcfUWIYFBvfwp6-5_Fyc=w128-h128-p-rp-mo-br100',
                'url' => 'https://maps.app.goo.gl/fzRBLQNTjZVMHH9r7'
            ],
            [
                'name' => 'Mark Fernandez',
                'date' => 'Um dia atrás',
                'rating' => 5,
                'content' => 'Excelente empresa. Recomendo.',
                'image' => 'https://lh3.googleusercontent.com/a/ACg8ocJlK1809ypLYngZ7rcguwRDqS01EMcjWkNZjwOfxUJR=w128-h128-p-rp-mo-br100',
                'url' => 'https://g.co/kgs/pgw6vQ'
            ]
        ];
    }
    
    /**
     * Obter dados do portfólio
     */
    public static function getPortfolio() {
        return [
            [
                'title' => 'Dilameti Express',
                'url' => 'https://dilameti.com.br',
                'image' => 'case-01.webp',
                'alt' => 'Imagem em miniatura do site desenvolvido para a empresa Dilameti Express',
                'description' => 'Site institucional com foco em logística e transporte'
            ],
            [
                'title' => 'O Resgate do Feminino',
                'url' => 'https://oresgatedofeminino.com.br/',
                'image' => 'case-02.webp',
                'alt' => 'Imagem em miniatura do site desenvolvido para Flavia Moura',
                'description' => 'Portal de conteúdo sobre desenvolvimento pessoal feminino'
            ],
            [
                'title' => 'J Reis Climatização',
                'url' => 'https://jreisclimatizacao.com.br/',
                'image' => 'case-03.webp',
                'alt' => 'Imagem em miniatura do site desenvolvido para a empresa J Reis Climatização',
                'description' => 'Website para empresa de climatização e refrigeração'
            ],
            [
                'title' => 'Mathias e Bernardes Advogados',
                'url' => 'https://sistema.mathiasebernardes.com.br/',
                'image' => 'case-04.webp',
                'alt' => 'Imagem em miniatura do site desenvolvido para a empresa Mathias e Bernades Advogados',
                'description' => 'Sistema web para escritório de advocacia'
            ],
            [
                'title' => 'Hyper Computer',
                'url' => 'https://hypercomputerbarra.com.br/',
                'image' => 'case-05.webp',
                'alt' => 'Imagem em miniatura do site desenvolvido para a empresa Hyper Computer',
                'description' => 'E-commerce e site institucional para loja de informática'
            ]
        ];
    }
    
    /**
     * Obter dados de redes sociais
     */
    public static function getSocialMedia() {
        return [
            [
                'name' => 'Facebook',
                'icon' => 'bi-facebook',
                'url' => FACEBOOK_URL
            ],
            [
                'name' => 'Instagram', 
                'icon' => 'bi-instagram',
                'url' => INSTAGRAM_URL
            ],
            [
                'name' => 'Google Meu Negócio',
                'icon' => 'bi-google',
                'url' => GOOGLE_BUSINESS_URL
            ]
        ];
    }
    
    /**
     * Obter URLs para sitemap
     */
    public static function getSitemapUrls() {
        return [
            [
                'loc' => url('/'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '1.0'
            ],
            [
                'loc' => url('/solucoes'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => url('/sobre'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ],
            [
                'loc' => url('/avaliacoes'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'weekly',
                'priority' => '0.6'
            ],
            [
                'loc' => url('/portifolio'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.8'
            ],
            [
                'loc' => url('/contato'),
                'lastmod' => date('Y-m-d'),
                'changefreq' => 'monthly',
                'priority' => '0.7'
            ]
        ];
    }
}