<?php
/**
 * @var string $theme
 */

$this->setData(['formDisabled' => true]);
$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('main') ?>
<div class="card mh65vh">
    <div class="card-content">
        <div class="row">
            <h3><?= lang('Admin.view') ?></h3>
            <?= $this->include('Admin\Categories\partials\category_form') ?>
        </div>
    </div>
</div>
<?php
$this->endSection() ?>
