<?php

$this->extend('AdminThemes\default\layouts\default') ?>

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
            <th><?= lang('Tables.categories.id') ?></th>
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
              <td><?= $category->id ?></td>
              <td><?= $category->name ?></td>
              <td><?= $category->description ?></td>
              <td><?= $category->is_system ?></td>
              <td><?= lang('{created, date} {created, time}', ['created' => $category->created]) ?></td>
              <td><?= lang('{updated, date} {updated, time}', ['updated' => $category->updated]) ?></td>
              <td>
                  <?= $this->include(
                      'Admin\Partials\table_action',
                      ['controller' => 'categories', 'id' => $category->id]
                  ) ?>
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
