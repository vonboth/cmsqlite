<?php

$this->setData(['edit' => false]);
$this->extend('AdminThemes\default\layout'); ?>

<?php
$this->section('main') ?>
  <div class="card">
    <div class="card-content">
      <div class="row">
        <h3><?= lang('Admin.view') ?></h3>
          <?= $this->include('Admin\Users\partials\user_form', ['disabled' => 1]) ?>
      </div>
    </div>
  </div>
<?php
$this->endSection() ?>