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
        <?= lang('Admin.edit') . ' ' . lang('Tables.articles.article') ?>
    </h3>
    <form>
        <div class="row">
            <?= $this->include('Admin\Articles\partials\article_form', ['disabled' => false]) ?>
        </div>
    </form>
<?php
$this->endSection() ?>

<?php
$this->section('js') ?>
    <script type="text/javascript">
      document.addEventListener('DOMContentLoaded', function() {
        let editor = ClassicEditor
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