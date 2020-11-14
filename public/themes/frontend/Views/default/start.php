<?php
/**
 * The content for the startpage
 * This file extends the default layout file
 *
 */

/** @var $article */
/** @var $layout */
?>

<?= $this->extend("Themes\\$layout\layouts\default") ?>

<?= $this->section('main') ?>
<h1>Hallo Public</h1>
<section>
    <?= $article->title ?>
  <p>
      <?= $article->content ?>
  </p>
</section>
<?= $this->endSection() ?>