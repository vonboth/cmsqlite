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
            <th><?= lang('username') ?></th>
            <th><?= lang('role') ?></th>
            <th><?= lang('email') ?></th>
            <th><?= lang('firstname') ?></th>
            <th><?= lang('lastname') ?></th>
            <th><?= lang('created') ?></th>
            <th><?= lang('updated') ?></th>
            <th><?= lang('action') ?></th>
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
                  <?= $this->include('Admin\Partials\table_action', ['controller' => 'users', 'id' => $user->id]) ?>
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
