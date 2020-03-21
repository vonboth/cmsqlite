<?= $this->extend('Themes\default\layout') ?>

<?= $this->section('main') ?>

    <h1>Hallo Public</h1>
    <section>
        <?= $title ?>
        <?= view_cell('\App\Views\Cells\Article::render') ?>
    </section>

<?= $this->endSection() ?>