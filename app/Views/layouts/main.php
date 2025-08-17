<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GA_TRACKING_ID ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '<?= GA_TRACKING_ID ?>');
            gtag('config', '<?= GOOGLE_ADS_ID ?>');
        </script>
        
        <title><?= e($title) ?></title>
        <meta name="description" content="<?= e($description) ?>">
        <link rel="canonical" href="<?= e($canonical) ?>" />
        <link rel="icon" type="image/x-icon" href="<?= asset('img/ico/favicon.ico') ?>">
        <link rel="preload" as="image" href="<?= asset('img/achar-marca.webp') ?>">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="<?= DEFAULT_KEYWORDS ?>">
        
        <!-- Open Graph tags para redes sociais -->
        <meta property="og:title" content="<?= e($title) ?>">
        <meta property="og:description" content="<?= e($description) ?>">
        <meta property="og:url" content="<?= e($canonical) ?>">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="pt_BR">
        <meta property="og:site_name" content="<?= APP_NAME ?>">
        <meta property="og:image" content="<?= asset('img/analitica-sistemas-logo.webp') ?>">
        
        <!-- Twitter Card -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="<?= e($title) ?>">
        <meta name="twitter:description" content="<?= e($description) ?>">
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <link href="<?= asset('css/estilo.css') ?>" rel="stylesheet">
        
        <!-- Schema.org markup para SEO -->
        <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "Organization",
            "name": "<?= APP_NAME ?>",
            "url": "<?= APP_URL ?>",
            "logo": "<?= asset('img/analitica-sistemas-logo.webp') ?>",
            "description": "<?= e($description) ?>",
            "address": {
                "@type": "PostalAddress",
                "addressRegion": "ES",
                "addressCountry": "BR"
            },
            "contactPoint": {
                "@type": "ContactPoint",
                "telephone": "<?= SITE_PHONE ?>",
                "contactType": "customer service",
                "availableLanguage": "Portuguese"
            },
            "sameAs": [
                "<?= FACEBOOK_URL ?>",
                "<?= INSTAGRAM_URL ?>"
            ]
        }
        </script>
    </head>
    <body>
        <?php if ($statusMessage): ?>
        <div class="alert alert-<?= $statusMessage['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert" style="margin-bottom: 0; border-radius: 0;">
            <?= e($statusMessage['message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>
        
        <?php include APP_PATH . '/Views/layouts/header.php'; ?>
        
        <main>
            <?= $content ?>
        </main>
        
        <?php include APP_PATH . '/Views/components/whatsapp-button.php'; ?>
        <?php include APP_PATH . '/Views/layouts/footer.php'; ?>
        
        <!-- Scripts -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-scroll para seção se especificado
                <?php if (isset($scrollTo)): ?>
                const section = document.querySelector('#<?= $scrollTo ?>');
                if (section) {
                    setTimeout(function() {
                        section.scrollIntoView({ behavior: 'smooth' });
                    }, 300);
                }
                <?php endif; ?>
                
                // Auto-hide alert após 5 segundos
                const alert = document.querySelector('.alert');
                if (alert) {
                    setTimeout(function() {
                        alert.classList.remove('show');
                        setTimeout(function() {
                            alert.remove();
                        }, 150);
                    }, 5000);
                }
                
                // Smooth scroll para links internos
                const internalLinks = document.querySelectorAll('a[href^="/"]');
                internalLinks.forEach(link => {
                    link.addEventListener('click', function(e) {
                        const href = this.getAttribute('href');
                        if (href === '/' || !href.includes('#')) return;
                        
                        const sectionId = href.substring(1);
                        const section = document.querySelector('#' + sectionId);
                        if (section) {
                            e.preventDefault();
                            section.scrollIntoView({ behavior: 'smooth' });
                            history.pushState(null, null, href);
                        }
                    });
                });
            });
        </script>
    </body>
</html>