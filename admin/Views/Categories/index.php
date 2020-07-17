<?php $this->extend('AdminThemes\default\layout.php') ?>

<?php $this->section('main')?>
<h1>The List of categories</h1>
<table>
    <thead>
    <tr>
        <th><?= lang('Tables.categories.name') ?></th>
        <th><?= lang('Tables.categories.description') ?></th>
        <th><?= lang('Tables.categories.is_system') ?></th>
        <th><?= lang('Tables.created') ?></th>
        <th><?= lang('Tables.updatedphp') ?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category): ?>
    <tr>
        <td><?= $category->name ?></td>
        <td><?= $category->description ?></td>
        <td><?= $category->is_system ?></td>
        <td><?= $category->created ?></td>
        <td><?= $category->updated ?></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<?php $this->endSection() ?>
