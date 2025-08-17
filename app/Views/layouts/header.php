<header class="cabecalho fixed-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= url('/') ?>">
                <img src="<?= asset('img/analitica-sistemas-logo.webp') ?>" alt="logomarca oficial da analítica sistemas">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?= url('/solucoes') ?>" class="nav-link <?= $activeSection === 'solucoes' ? 'active' : '' ?>">Soluções</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url('/sobre') ?>" class="nav-link <?= $activeSection === 'sobre' ? 'active' : '' ?>">Sobre</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url('/avaliacoes') ?>" class="nav-link <?= $activeSection === 'avaliacoes' ? 'active' : '' ?>">Avaliações</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url('/portifolio') ?>" class="nav-link <?= $activeSection === 'portifolio' ? 'active' : '' ?>">Portfólio</a>
                    </li>
                    <li class="nav-item">
                        <a href="<?= url('/contato') ?>" class="nav-link <?= $activeSection === 'contato' ? 'active' : '' ?>">Contato</a>
                    </li>
                </ul> 
            </div>
        </div>
    </nav>
</header>