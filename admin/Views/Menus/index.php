<?php
/**
 * view to create menus
 */

/**
 * @var $menus
 * @var $menuitems
 * @var \Admin\Models\Entities\Article[] $articles
 * @var string $theme
 * @var \Admin\Models\Entities\Category[] $categories a list of categories
 */

$this->extend("AdminThemes\\$theme\\layouts\\default")
?>

<?php
$this->section('main') ?>
<?= $this->include('Admin\Partials\form_errors'); ?>

<menus csrf-token="<?= csrf_hash() ?>"
       :menus="<?= esc(json_encode(array_values($menus))) ?>"
       :categories="<?= esc(json_encode(array_values($categories))) ?>"
       :articles="<?= esc(json_encode(array_values($articles))) ?>"></menus>

<?php
$this->endSection() ?>
