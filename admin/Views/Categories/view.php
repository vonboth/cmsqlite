<?php $this->extend('AdminThemes\default\layout') ?>

<?php $this->section('headerScripts')?>
<?= script_tag('js/ckeditor/classic/ckeditor.js') ?>
<?php $this->endSection() ?>

<?php $this->section('main') ?>
<h2>
    <?= lang('view') . lang('categories') ?>
</h2>
<form>
<div class="row">
    <div class="col s12">
        <section class="article">

        </section>
    </div>
</div>
</form>
<?php $this->endSection() ?>