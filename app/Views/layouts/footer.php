<?php
use App\Models\Page;

$socialMedia = Page::getSocialMedia();
?>
<footer class="rodape">
    <span class="copyright">Copyright © <?= $year ?> | <strong><?= APP_NAME ?>.</strong></span>
    <div class="social-media-icons">
        Siga a gente nas redes sociais: 
        <?php foreach ($socialMedia as $social): ?>
        <a class="social-media-icon-link py-1" href="<?= $social['url'] ?>" target="_blank" rel="noopener">
            <i class="bi <?= $social['icon'] ?>"></i>
            <?= $social['name'] ?>
        </a>
        <?php endforeach; ?>
    </div>
</footer>