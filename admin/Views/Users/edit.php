<?php

$this->setData(['edit' => true]);
$this->extend('AdminThemes\default\layouts\default');
?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card">
  <div class="card-content">
    <div class="row">
      <h3><?= lang('Admin.edit') ?></h3>
        <?= form_open('/admin/users/edit/' . $user->id, 'class="col s12"') ?>
        <?= $this->include('Admin\Users\partials\user_form', ['disabled' => 0]) ?>
        <?= form_close() ?>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
