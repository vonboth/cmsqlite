<?php
/**
 * The content for the startpage
 * This file extends the default layout file
 *
 */

/** @var \Admin\Models\Entities\Article $article */
/** @var string $theme */
?>

<?= $this->extend("Themes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
  <section>
    <p>
        <?= $article->content ?>
    </p>
  </section>
<?= $this->endSection() ?>