<?= $this->extend('Install\layouts\default') ?>

<?= $this->section('main') ?>
    <div class="card-panel">
        <div class="row">
            <div class="col s12">
                <div role="alert" class="card-panel red lighten-2">
                    <?= lang('Install.root_not_writable') ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h3><?= lang('Install.create_file') ?></h3>
                <p><?= lang('Install.create_file_text') ?></p>
                <div class="card-panel grey lighten-3">
                    <pre><?= $content ?></pre>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <div role="alert" class="card-panel blue lighten-4">
                    <i class="material-icons left">info</i>
                    <?= lang('Install.env_file_note') ?>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <div role="alert" class="card-panel blue lighten-4">
                    <i class="material-icons left">info</i>
                    <?= lang('Install.recommend_delete_install') ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>