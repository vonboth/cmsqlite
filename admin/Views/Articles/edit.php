<?php
/**
 * @var \Admin\Models\Entities\Article $article
 * @var string $theme
 */

$this->setData(['formDisabled' => false]);
$this->extend("AdminThemes\\$theme\\layouts\\default");
$this->section('main');
?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card mh65vh">
  <div class="card-content">
    <div class="row">
      <h3><?= lang('admin.edit') ?></h3>
        <?= form_open('/admin/articles/edit/' . $article['id'], 'class="col s12"') ?>
        <?= $this->include('Admin\Articles\partials\article_form') ?>
        <?= form_close() ?>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
