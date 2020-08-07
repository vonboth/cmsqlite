<?php

$this->setData(['edit' => true]);
$this->extend('AdminThemes\default\layout');
?>

<?php
$this->section('main') ?>
<div class="row">
  <h3><?= lang('Admin.edit') . ' ' . lang('Tables.users.user') ?></h3>

    <?= $this->include('Admin\Partials\form_errors'); ?>

    <?= form_open('/admin/users/edit' . $user->id, 'class="col s12"') ?>
    <?= $this->include('Admin\Users\partials\user_form', ['disabled' => 0]) ?>
    <?= form_close() ?>
</div>
<?php
$this->endSection() ?>
