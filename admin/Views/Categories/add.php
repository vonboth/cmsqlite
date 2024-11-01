<?php
/**
 * @var string $theme
 */

$this->setData(['formDisabled' => false]);
$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card mh65vh">
  <div class="card-content">
    <div class="row">
      <h3><?= lang('admin.add') ?></h3>
        <?= form_open('/admin/categories/add', 'class="col s12"') ?>
        <?= $this->include('Admin\Categories\partials\category_form') ?>
        <?= form_close() ?>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
