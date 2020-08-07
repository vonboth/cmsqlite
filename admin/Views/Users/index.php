<?php

$this->extend('AdminThemes\default\layout.php') ?>

<?php
$this->section('main') ?>
<h3>
  <span><?= lang('users') ?></span>
  <a href="/admin/users/add"
     class="btn-floating waves-effect waves-light red">
    <i class="material-icons">add</i>
  </a>
</h3>

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
      <td><?= format_date('d.m.Y H:i:s', $user->created) ?></td>
      <td><?= format_date('d.m.Y H:i:s', $user->updated) ?></td>
      <td>
          <?= $this->include('Admin\Partials\table_action', ['controller' => 'users', 'id' => $user->id]) ?>
      </td>
    </tr>
  <?php
  endforeach; ?>
  </tbody>
</table>
<?php
$this->endSection() ?>
