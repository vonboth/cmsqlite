<?php
/**
 * @var $theme
 */

$this->setData(['formDisabled' => true]);
$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('main') ?>
  <div class="card">
    <div class="card-content">
      <div class="row">
        <h3><?= lang('Admin.view') ?></h3>
          <?= $this->include('Admin\Articles\partials\article_form') ?>
      </div>
    </div>
  </div>
<?php
$this->endSection() ?>

<?php
$this->section('js') ?>
<?= $this->include('Admin\Articles\partials\ckeditor') ?>
<?php
$this->endSection() ?>