<?php

$this->extend('AdminThemes\default\layouts\default') ?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card">
  <div class="card-content">
    <div class="row">
      <h3><?= lang('Admin.edit') ?></h3>
        <?= form_open('/admin/categories/edit/' . $category->id, 'class="col s12"') ?>
        <?= $this->include('Admin\Categories\partials\category_form', ['disabled' => 0]) ?>
        <?= form_close() ?>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
