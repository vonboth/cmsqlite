<?php

$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('headerScripts') ?>
<?= script_tag('js/ckeditor/classic/ckeditor.js') ?>
<?php
$this->endSection() ?>

<?php
$this->section('main') ?>
    <h3>
        <?= lang('Admin.view') . ' ' . lang('Tables.articles.article') ?>
    </h3>
    <div class="row">
        <?= $this->include('Admin\Articles\partials\article_form', ['disabled' => 1]) ?>
    </div>
<?php
$this->endSection() ?>
<?php
$this->section('js') ?>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        ClassicEditor
          .create(document.getElementById('editor'), {
            language: 'de'
          })
          .then(editor => {
            editor.isReadOnly = true;
          })
          .catch(error => {
            console.error(error);
          });
      });
    </script>
<?php
$this->endSection() ?>