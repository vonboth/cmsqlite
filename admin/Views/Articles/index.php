<?php
/**
 * @var \Admin\Models\Entities\Article[] $articles
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
            <th><?= lang('admin.actions') ?></th>
            <th>ID</th>
            <th><?= lang('admin.tables.title') ?></th>
            <th><?= lang('admin.tables.description') ?></th>
            <th><?= lang('admin.tables.articles.category_id') ?></th>
            <th><?= lang('admin.tables.articles.published') ?></th>
            <th><?= lang('admin.created') ?></th>
            <th><?= lang('admin.updated') ?></th>
          </tr>
          </thead>
          <tbody>
          <?php
          foreach ($articles as $article): ?>
            <tr>
              <td>
                <?php
                $this->setData(['controller' => 'articles', 'data_id' => $article->id]) ?>
                <?= $this->include('Admin\Partials\table_action') ?>
              </td>
              <td><?= $article->id ?></td>
              <td><?= $article->title ?> <?= $article->is_startpage ?
                  '(<span title="' . lang('admin.tables.articles.is_startpage') . '"><i class="material-icons tiny">check</i></span>)'
                  : '' ?></td>
              <td><?= $article->description ?></td>
              <td>
                <?= (is_null($article->category)) ? '' : $article->category->name ?>
              </td>
              <td><?= $article->published ?
                  '<span><i class="material-icons">check</i></span>'
                  : '<span><i class="material-icons">clear</i></span>' ?>
              </td>
              <td>
                <?= lang('{created, date} {created, time}', ['created' => $article->created]) ?>
              </td>
              <td>
                <?= lang('{updated, date} {updated, time}', ['updated' => $article->updated]) ?>
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
