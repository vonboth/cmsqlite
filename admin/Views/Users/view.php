<?php

$this->extend('AdminThemes\default\layout');
?>

<?php $this->section('main') ?>
    <div class="row">
        <div class="col s12 m6">
            <div class="card">
                <div class="card-content">
                    <span class="card-title"><?= $user->username ?></span>
                    <div class="field-view">
                        <label><?= lang('email') ?></label>
                        <p>
                            some email
                            <?= $user->email ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->endSection() ?>