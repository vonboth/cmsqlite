<?php
/**
 * @var string $theme
 * @var string $currentPath
 * @var array $dirs
 * @var array $files
 * @var array $directoryContent
 */

$this->extend("AdminThemes\\$theme\\layouts\\default"); ?>

<?php
$this->section('main') ?>

<file-browser csrf-token="<?= csrf_hash() ?>"
              :directory-content="<?= esc(json_encode($directoryContent)) ?>"/>

<?php
$this->endSection() ?>
