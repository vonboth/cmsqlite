<?php
/**
 * @var string $theme
 * @var array $settings
 */

$this->extend("AdminThemes\\$theme\\layouts\\default");

$this->section('main'); ?>
  <settings csrf-token="<?= csrf_hash() ?>"
            :settings="<?= esc(json_encode($settings)) ?>"></settings>
<?php
$this->endSection();
?>
