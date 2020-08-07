<?php

$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('main') ?>
<div class="row">
  <h3><?= lang('Admin.view') . ' ' . lang('Tables.categories.category') ?></h3>
    <?= $this->include('Admin\Categories\partials\category_form', ['disabled' => 1]) ?>
</div>
<?php
$this->endSection() ?>
