<?php
/**
 * @var string $theme the theme configured
 * @var \Admin\Models\Entities\Article $article the article
 */

?>
<?= $this->extend("Themes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>

<h1>Hallo Public</h1>
<section>
    <?= $article->title ?>
    <?= view_cell('Views\Cells\Article::render', ['alias' => 'startseite']) ?>
</section>
<section>
    Menus
    <?= view_cell('Views\Cells\Menu::render', ['id' => 1]) ?>
</section>
<section>
    Slider
    <?= view_cell('Views\Cells\Slider::render', ['path' => 'slider']) ?>
</section>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<?= script_tag('themes/frontend/Views/default/js/materialize.min.js') ?>
<?= $this->endSection() ?>
