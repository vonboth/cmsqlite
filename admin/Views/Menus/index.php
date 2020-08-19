<?php

/** @var $menutrees */

/** @var $menus */
/** @var $articles */

$this->extend('AdminThemes\default\default') ?>

<?php
$this->section('main') ?>
<div class="row">
  <div class="col s12">
    <a href="javascript: void(0)"
       @click="onAddMenu"
       class="btn-floating waves-effect waves-light blue">
      <i class="material-icons">add</i>
    </a>
  </div>
</div>
<div class="row">
  <div class="col s4">
      <?= admin_menu_tree($menutrees) ?>
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
  var menus = <?= json_encode($menus) ?>;
</script>
<?php
$this->endSection('js') ?>
