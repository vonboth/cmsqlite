<?php
/**
 * @var string $theme the current layout from the settings
 */

?>
<?= $this->extend("Themes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
<main role="main" class="section no-pad-bot">
    <section class="container">
        <?= $article->content ?>
    </section>
</main>
<?= $this->endSection() ?>

