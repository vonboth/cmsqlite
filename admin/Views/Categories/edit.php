<?php $this->extend('AdminThemes\default\layout') ?>

<?php $this->section('headerScripts')?>
<?php $this->endSection() ?>

<?php $this->section('main') ?>
<h2>
    <?= lang('edit') . lang('categories') ?>
</h2>
<form method="post">
<div class="row">
    <div class="col s12">
        <section class="">
        </section>
    </div>
</div>
</form>
<?php $this->endSection() ?>