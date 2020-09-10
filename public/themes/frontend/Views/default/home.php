<?= $this->extend("Themes\default\default") ?>

<?= $this->section('main') ?>

  <h1>Hallo Public</h1>
  <section>
      <?= $title ?>
      <?= view_cell('\App\Views\Cells\Article::render', ['alias' => 'startpage']) ?>
  </section>
  <section>
      Menus
    <?= view_cell('\App\Views\Cells\Menu::render', ['id' => 1]) ?>
  </section>

<?= $this->endSection() ?>