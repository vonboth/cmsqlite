<?php

/**
 * @var string $theme
 */

$this->extend("AdminThemes\\$theme\\layouts\\default");
?>

<?php
$this->section('main');
echo $this->include('Admin\Partials\form_errors'); ?>

<?php
$this->endSection() ?>
