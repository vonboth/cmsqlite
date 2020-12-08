<?php
/**
 * @var string $theme the current layout from the settings
 */

?>
<?= $this->extend("Themes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
<section></section>
<?= $this->endSection() ?>

