<?php
$this->setData(
    [
        'edit' => true,
        'disabled' => false
    ]
);
$this->extend('AdminThemes\default\layout');
?>

<?php $this->section('main') ?>
    <h2><?= lang('edit') . lang('users') ?></h2>
    <div class="row">
        <div class="col s12">
            <?= $validator->listErrors() ?>
        </div>
    </div>
<?= form_open(
    'admin/users/edit/' . $user->id,
    [
        'class' => 'col s12'
    ]
) ?>
<?= $this->include('Admin\Users\user_form') ?>
    <div class="row">
        <div class="col s3">
            <button class="btn waves-effect waves-light" type="submit" name="action"><?= lang('save') ?>
                <i class="material-icons right">send</i>
            </button>
        </div>
    </div>
<?= form_close() ?>
<?php $this->endSection() ?>