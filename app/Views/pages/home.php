<?php
use App\Models\Page;

$solutions = Page::getSolutions();
$reviews = Page::getReviews();
$portfolio = Page::getPortfolio();
?>
<section class="apresentacao">
    <article class="apresentacao-argument">
        <h1>Sua marca está visível na Internet??</h1>
        <p>Segundo dados do Instituto Brasileiro de Geografia e Estatística (IBGE), <strong>mais de 50 % dos brasileiros utilizam a Internet como principal meio de comunicação e de informação</strong>!</p>
        <a href="https://wa.me/<?= SITE_WHATSAPP ?>?text=Acabo de visitar seu site e gostaria de mais informações por favor." target="_blank" rel="noopener">
            <button class="btn btn-primary btn-lg text-center mx-auto d-block">Preciso de ajuda!</button>
        </a>
    </article>
</section>

<section class="solucoes" id="solucoes">
    <article>
        <h2>Soluções</h2>
        <p>Calma, se o seu negócio ou a sua empresa ainda não tem uma página na Internet, <strong>nós podemos ajudar!</strong> Veja <strong>algumas das soluções que oferecemos aos nossos clientes</strong>:</p>
        <div class="card-container">
            <?php foreach ($solutions as $solution): ?>
            <div class="card">
                <h3 class="solucao-title"><?= $solution['title'] ?></h3>
                <img class="solucao-img" src="<?= asset('img/solucoes/' . $solution['image']) ?>" alt="<?= e($solution['alt']) ?>" loading="lazy">
                <p class="solucao-parag">
                    <?= $solution['description'] ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<section class="sobre" id="sobre">
    <article>
        <h2>Sobre</h2>
        <p>Por que <strong>escolher a Analítica Soluções</strong>?</p>
        <p>Somos uma <strong>empresa capixaba</strong> com foco na <strong>prestação de serviços com alta qualidade</strong> e <strong>soluções personalizadas</strong> 
            para melhor atender às necessidades dos nossos clientes. A Analítica Soluções <strong>usa as melhores técnicas disponíveis</strong> no desenvolvimento de páginas dinâmicas para o seu negócio.
        </p>
        <p>Enquanto o mercado oferece plataformas prontas e sites genéricos desenvolvidos com frameworks engessados, aqui <strong>na Analítica Soluções priorizamos o desenvolvimento
                de páginas únicas, originais e modernas</strong> que permitirão ao seu negócio ter uma identidade diferenciada na Internet e perante seus clientes.</p>
        <p>Nosso <strong>diferencial</strong> é oferecer uma <strong>integração prática e eficiente entre o site da sua empresa e seus perfis nas redes sociais</strong>, permitindo que seu conteúdo seja dinâmico
            e constantemente atualizado de forma automática.</p>
    </article>
</section>

<section class="avaliacoes" id="avaliacoes">
    <article>
        <h2>Avaliações</h2>
        Veja algumas das avaliações feitas pelos nossos clientes:<br/>
        <div class="reviews-container d-flex flex-row row align-itens-center justify-content-center">
            <?php foreach ($reviews as $review): ?>
            <div class="review col-12 col-lg-5">
                <a href="<?= $review['url'] ?>" target="_blank" rel="noopener">
                    <div class="perfil-img">
                        <img src="<?= $review['image'] ?>" alt="foto de perfil do <?= e($review['name']) ?>" loading="lazy">
                    </div>
                    <div class="perfil-nome"><?= e($review['name']) ?></div>
                    <div class="review-data"><?= e($review['date']) ?></div>
                    <div class="review-estrelas">
                        <?php for ($i = 0; $i < $review['rating']; $i++): ?>
                        <span class="estrela"></span>
                        <?php endfor; ?>
                    </div>
                    <div class="review-conteudo">
                        <?= e($review['content']) ?>
                    </div>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<section class="portifolio d-flex" id="portifolio">
    <article class="align-itens-center justify-content-center">
        <h2>Portfólio</h2>
        <p class="text-center">Conheça alguns de nossos <strong>projetos</strong>:</p>
        <div class="galeria row flex-row align-itens-center justify-content-center">
            <?php foreach ($portfolio as $project): ?>
            <div class="img-galeria col-12 col-lg-3 text-center my-4 w-auto">
                <a href="<?= $project['url'] ?>" target="_blank" rel="noopener" title="<?= e($project['title']) ?>">
                    <img src="<?= asset('img/portifolio/' . $project['image']) ?>" class="img-thumbnail" loading="lazy" alt="<?= e($project['alt']) ?>">
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </article>
</section>

<section class="contato" id="contato">
    <article>
        <h2>Contato</h2>
        <p>Entre em contato e <strong>peça um orçamento</strong> personalizado:</p>
        <?php include APP_PATH . '/Views/components/contact-form.php'; ?>
    </article>
</section>