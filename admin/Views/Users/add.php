<?php
/**
 * @var string $theme
 */

$this->setData(['edit' => false]);
$this->extend("AdminThemes\\$theme\\layouts\\default");
?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card">
  <div class="card-content">
    <div class="row">
      <h3><?= lang('Admin.add') ?></h3>
        <?= form_open('/admin/users/add', 'class="col s12"') ?>
        <?= $this->include('Admin\Users\partials\user_form', ['disabled' => 0]) ?>
        <?= form_close() ?>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
