<?php
$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('main') ?>
<div id="articles">
  <h3><?= lang('Admin.view') . ' ' . lang('Tables.articles.article') ?></h3>
  <?= $this->include('Admin\Articles\partials\article_form', ['disabled' => 1]) ?>
</div>
<?php
$this->endSection() ?>
