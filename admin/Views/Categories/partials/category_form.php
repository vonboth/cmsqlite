<?php
/** @var \Admin\Models\Entities\Category $category */

/** @var bool $formDisabled */
/** @var string $controller */

?>
<!-- Category Form -->
<div class=row>
    <div class="col s12 <?= (is_null($category->id) ? 'hide' : '') ?>">
        <span class="right">
            <?= 'ID:' . $category->id
            . ' | ' . lang('admin.created') . ': ' . lang(
                '{created, date} {created, time}',
                ['created' => $category->created ?? new DateTime()]
            )
            . ' | ' . lang('admin.updated') . ': ' . lang(
                '{updated, date} {updated, time}',
                ['updated' => $category->updated ?? new DateTime()]
            ) ?>
        </span>
    </div>
</div>

<div class="row">
    <div class="input-field col s12 m8">
        <input name="name"
               class="validate"
               required
            <?= ($formDisabled) ? 'disabled' : '' ?>
               id="name"
               type="text"
               value="<?= old('name', $category->name) ?>"/>
        <label for="name"><?= lang('admin.tables.name') ?></label>
    </div>
    <div class="input-field col s12 m2">
        <label>
            <input name="is_system"
                <?= ($formDisabled) ? 'disabled' : '' ?>
                   type="checkbox"
                   value="1"
                <?= (old('is_system', $category->is_system)) ? 'checked' : '' ?> />
            <span><?= lang('admin.tables.categories.is_system') ?></span>
        </label>
    </div>
</div>
<div class="row">
    <div class="input-field col s12">
        <textarea id="description"
                  <?= ($formDisabled) ? 'disabled' : '' ?>
                  name="description"
                  class="materialize-textarea"><?= old('description', $category->description) ?></textarea>
        <label for="description"><?= lang('admin.tables.description') ?></label>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <a href="/admin/<?= $controller ?>"
           class="btn waves-effect waves-light"><?= lang('admin.back') ?>
            <i class="material-icons left">arrow_back</i></a>
        <?php
        if (!$formDisabled) : ?>
            <button type="submit" class="btn waves-effect waves-light ml1rem"><?= lang('admin.submit') ?>
                <i class="material-icons right">send</i></button>
        <?php
        endif; ?>
    </div>
</div>
