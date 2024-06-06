<?php
/**
 * @var string $theme
 * @var string $editor_style
 */

$this->setData(['formDisabled' => false]);
$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('headerScripts') ?>
<script src="//cdn.ckeditor.com/4.22.1/<?= $editor_style ?>/ckeditor.js"></script>
<?php
$this->endSection() ?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card mh65vh">
    <div class="card-content">
        <div class="row">
            <h3><?= lang('Admin.add') ?></h3>
            <?= form_open('/admin/articles/add', 'class="col s12"') ?>
            <?= $this->include('Admin\Articles\partials\article_form') ?>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php
$this->endSection() ?>
