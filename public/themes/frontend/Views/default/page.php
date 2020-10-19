<?= $this->extend("Themes\\$layout\layouts\default") ?>

<?= $this->section('main') ?>

  <h1>Hallo Public</h1>
  <section>
      <?= $article->title ?>
      <?= view_cell('Views\Cells\Article::render', ['alias' => 'startpage']) ?>
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