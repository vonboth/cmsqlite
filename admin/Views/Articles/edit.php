<?php

$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('main') ?>
<div id="articles">
  <h3><?= lang('Admin.edit') . ' ' . lang('Tables.articles.article') ?></h3>

    <?= $this->include('Admin\Partials\form_errors'); ?>

    <?= form_open('/admin/articles/edit' . $article->id, 'class="col s12"') ?>
    <?= $this->include('Admin\Articles\partials\article_form', ['disabled' => false]) ?>
    <?= form_close() ?>
</div>
<?php
$this->endSection() ?>
