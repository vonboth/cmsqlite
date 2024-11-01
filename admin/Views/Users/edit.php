<?php
/**
 * @var string $theme
 */

/** @var \Admin\Models\Entities\User $user */

$this->setData(['edit' => true]);
$this->setData(['formDisabled' => false]);
$this->extend("AdminThemes\\$theme\\layouts\\default");
?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card mh65vh">
    <div class="card-content">
        <div class="row">
            <h3><?= lang('admin.edit') ?></h3>
            <?= form_open('/admin/users/edit/' . $user->id, 'class="col s12"') ?>
            <?= $this->include('Admin\Users\partials\user_form') ?>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?php
$this->endSection() ?>
