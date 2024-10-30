<?php
/**
 * @var $theme
 * @var $editor_style
 */

$this->setData(['formDisabled' => true]);
$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('headerScripts') ?>
    <script src="//cdn.ckeditor.com/4.22.1/<?= $editor_style ?>/ckeditor.js"></script>
<?php
$this->endSection() ?>

<?php
$this->section('main') ?>
  <div class="card mh65vh">
    <div class="card-content">
      <div class="row">
        <h3><?= lang('all.view') ?></h3>
          <?= $this->include('Admin\Articles\partials\article_form') ?>
      </div>
    </div>
  </div>
<?php
$this->endSection() ?>
