<?php

$this->extend('AdminThemes\default\layout.php') ?>

<?php
$this->section('main') ?>
<h3>
  <span><?= lang('Tables.categories.categories') ?></span>
  <a href="/admin/categories/add"
     class="btn-floating waves-effect waves-light red">
    <i class="material-icons">add</i>
  </a>
</h3>

<table class="responsive-table">
  <thead>
  <tr>
    <th><?= lang('Tables.categories.name') ?></th>
    <th><?= lang('Tables.categories.description') ?></th>
    <th><?= lang('Tables.categories.is_system') ?></th>
    <th><?= lang('Tables.created') ?></th>
    <th><?= lang('Tables.updated') ?></th>
    <th><?= lang('Tables.actions') ?></th>
  </tr>
  </thead>
  <tbody>
  <?php
  foreach ($categories as $category): ?>
    <tr>
      <td><?= $category->name ?></td>
      <td><?= $category->description ?></td>
      <td><?= $category->is_system ?></td>
      <td><?= $category->created ?></td>
      <td><?= $category->updated ?></td>
      <td>
          <?= $this->include('Admin\Partials\table_action', ['controller' => 'categories', 'id' => $category->id]) ?>
      </td>
    </tr>
  <?php
  endforeach; ?>
  </tbody>
</table>
<?php
$this->endSection() ?>
