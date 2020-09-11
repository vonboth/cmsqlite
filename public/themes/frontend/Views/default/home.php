<?= $this->extend("Themes\default\default") ?>

<?= $this->section('main') ?>

  <h1>Hallo Public</h1>
  <section>
      <?= $title ?>
      <?= view_cell('ViewCells\Article::render', ['alias' => 'startpage']) ?>
  </section>
  <section>
    Menus
      <?= view_cell('ViewCells\Menu::render', ['id' => 1]) ?>
  </section>
  <section>
    Slider
    <?= view_cell('ViewCells\Slider::render', ['path' => 'slider']) ?>
  </section>

<?= $this->endSection() ?>