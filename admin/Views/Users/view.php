<?php

$this->setData(['edit' => false]);
$this->extend('AdminThemes\default\layout'); ?>

<?php
$this->section('main') ?>
  <div class="row">
    <h3><?= lang('Admin.view') . ' ' . lang('Tables.users.user') ?></h3>
      <?= $this->include('Admin\Users\partials\user_form', ['disabled' => 1]) ?>
  </div>
<?php
$this->endSection() ?>