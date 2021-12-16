<?php
/**
 * @var string $theme
 */

$this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\add_button') ?>

<div class="row">
    <div class="col s12">
        <div class="card">
            <div class="card-content">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th><?= lang('Tables.users.username') ?></th>
                        <th><?= lang('Tables.users.role') ?></th>
                        <th><?= lang('Tables.users.email') ?></th>
                        <th><?= lang('Tables.users.firstname') ?></th>
                        <th><?= lang('Tables.users.lastname') ?></th>
                        <th><?= lang('Tables.created') ?></th>
                        <th><?= lang('Tables.updated') ?></th>
                        <th><?= lang('Tables.actions') ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($users as $user): ?>
                        <tr>
                            <td><?= $user->username ?></td>
                            <td><?= $user->role ?></td>
                            <td><?= $user->email ?></td>
                            <td><?= $user->firstname ?></td>
                            <td><?= $user->lastname ?></td>
                            <td><?= lang('{created, date} {created, time}', ['created' => $user->created]) ?></td>
                            <td><?= lang('{updated, date} {updated, time}', ['updated' => $user->updated]) ?></td>
                            <td>
                                <?php
                                $this->setData(['controller' => 'users', 'data_id' => $user->id]) ?>
                                <?= $this->include('Admin\Partials\table_action') ?>
                            </td>
                        </tr>
                    <?php
                    endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
$this->endSection() ?>
