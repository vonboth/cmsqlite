<?php

/** @var $menus */

/** @var $articles */
/** @var $menuitems */

$this->extend('AdminThemes\default\default') ?>

<?php
$this->section('main') ?>
<div class="row">
  <div class="col s4">
    <?= admin_menu_tree($menus) ?>
  </div>
  <div class="col s8">
    <?= $this->include('\Admin\Menus\partials\menu_form') ?>
  </div>
</div>

<?php
$this->endSection() ?>

<?php
$this->section('js') ?>
<script>
  var menuitems = <?= json_encode($menuitems) ?>;
</script>
<?php
$this->endSection('js') ?>
