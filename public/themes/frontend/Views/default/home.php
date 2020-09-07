<?= $this->extend("Themes\default\default") ?>

<?= $this->section('main') ?>

  <h1>Hallo Public</h1>
  <section>
      <?= $title ?>
      <?= view_cell('\App\Views\Cells\Article::render') ?>
  </section>
  <section>
      Menus
    <?= menu_list($menus['main']->tree) ?>
  </section>

<?= $this->endSection() ?>