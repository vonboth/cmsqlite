<?php
$this->extend('AdminThemes\default\layout') ?>

<?php
$this->section('main') ?>
<div class="row">
    <h3>
        <?= lang('Admin.add') . ' ' . lang('Tables.articles.article') ?>
    </h3>
    <?= $this->include('Admin\Articles\partials\article_form', ['disabled' => 0]) ?>
</div>
<?php
$this->endSection() ?>

<?php
$this->section('scripts') ?>
<script type="text/javascript" src="/js/ckeditor/classic/translations/de.js"></script>
<script type="text/javascript" src="/js/ckeditor/classic/ckeditor.js"></script>
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
      .catch(error => {
        console.error(error);
      });

    M.Datepicker.init(document.querySelectorAll('#start_publish'));
    M.Datepicker.init(document.querySelectorAll('#stop_publish'));
  });
</script>
<?php
$this->endSection() ?>
