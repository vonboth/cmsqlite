<?php
$this->extend('AdminThemes\default\layout.php') ?>

<?php
$this->section('main') ?>
<h3>
    <span><?= lang('Tables.articles.articles') ?></span>
    <a href="/admin/articles/add"
       class="btn-floating waves-effect waves-light red">
        <i class="material-icons">add</i>
    </a>
</h3>

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
                <?= $this->include('Admin\Partials\table_action', ['controller' => 'articles', 'id' => $article->id]) ?>
            </td>
        </tr>
    <?php
    endforeach; ?>
    <tr></tr>
    </tbody>
</table>
<?php
$this->endSection() ?>
