<?php

$this->extend('AdminThemes\default\layout.php') ?>

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
            <th><?= lang('title') ?></th>
            <th><?= lang('action') ?></th>
          </tr>
          </thead>
          <tbody>
          <?php
          foreach ($articles as $article): ?>
            <tr>
              <td><?= $article->title ?></td>
              <td>
                  <?= $this->include(
                      'Admin\Partials\table_action',
                      ['controller' => 'articles', 'id' => $article->id]
                  ) ?>
              </td>
            </tr>
          <?php
          endforeach; ?>
          <tr></tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
$this->endSection() ?>
