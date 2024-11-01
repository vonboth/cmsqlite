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
        <div class="card mh65vh">
            <div class="card-content">
                <table class="responsive-table">
                    <thead>
                    <tr>
                        <th><?= lang('admin.tables.users.username') ?></th>
                        <th><?= lang('admin.tables.users.role') ?></th>
                        <th><?= lang('admin.tables.users.email') ?></th>
                        <th><?= lang('admin.tables.users.firstname') ?></th>
                        <th><?= lang('admin.tables.users.lastname') ?></th>
                        <th><?= lang('admin.created') ?></th>
                        <th><?= lang('admin.updated') ?></th>
                        <th><?= lang('admin.actions') ?></th>
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
