<?php
/**
 * view to create menus
 */

/**
 * @var $menutrees
 * @var $menus
 * @var $menuitems
 * @var $articles
 * @var string $theme
 */

$this->extend("AdminThemes\\$theme\\layouts\\default")
?>

<?php
$this->section('main') ?>
<?= $this->include('Admin\Partials\form_errors'); ?>

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
    <?= $this->include('\Admin\Menus\partials\menuitem_form') ?>
  </div>
</div>

<?php
$this->endSection() ?>

<?php
$this->section('js_vars') ?>
<script>
  const menus = <?= json_encode(array_values($menus)) ?>;
  const menuitems = <?= json_encode(array_values($menuitems)) ?>;
  const prevItem = <?= session('menuitem') ? session('menuitem') : 'false' ?>;
</script>
<?php
$this->endSection('js_vars') ?>

<?php
$this->section('js') ?>
<script type="text/javascript">
  if (prevItem) {
    adminVue.presetItem(prevItem);
  }
</script>
<?php
$this->endSection('js') ?>
