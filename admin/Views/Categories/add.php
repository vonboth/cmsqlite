<?php

$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('main') ?>
<div class="row">
  <h3><?= lang('Admin.add') . ' ' . lang('Tables.categories.category') ?></h3>

    <?= $this->include('Admin\Partials\form_errors'); ?>

    <?= form_open('/admin/categories/add', 'class="col s12"') ?>
    <?= $this->include('Admin\Categories\partials\category_form', ['disabled' => 0]) ?>
    <?= form_close() ?>
</div>
<?php
$this->endSection() ?>
