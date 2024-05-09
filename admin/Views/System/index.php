<?php

/**
 * @var string $theme
 */

$this->extend("AdminThemes\\$theme\\layouts\\default");
?>

<?php
$this->section('main'); ?>

<div class="card">
    <div class="card-content">
        <div class="row">
            <h3>System</h3>
            <div>
                <ul class="flex">
                    <li class="flex flex-center">
                        <form method="post" action="/admin/system/migrate">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                            <button class="btn-large waves-effect waves-light flex flex-center"
                                    type="submit">
                                <i class="material-icons">build</i> <span>Run Migrations</span>
                            </button>
                        </form>
                    </li>

                    <li class="ml1rem">
                        <form method="post" action="/admin/system/clearcache">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                            <button class="btn-large waves-effect waves-light flex flex-center"
                                    type="submit">
                                <i class="material-icons">delete</i> <span>Clear Cache</span>
                            </button>
                        </form>
                    </li>

                    <li class="ml1rem">
                        <form method="post" action="/admin/system/clearlogs">
                            <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>">
                            <button class="btn-large waves-effect waves-light flex flex-center"
                                    type="submit">
                                <i class="material-icons">delete</i> <span>Clear Logs</span>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
</div>

<?php
$this->endSection() ?>
