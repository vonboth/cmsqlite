<?php
/** @var \Admin\Models\Entities\Category $category */

?>
<!-- Category Form -->
<div class=row>
  <div class="col s12 <?= (is_null($category->id) ? 'hide' : '') ?>">
        <span class="right">
            <?= lang('Tables.created') . ': ' . lang('{created, date} {created, time}', ['created' => $category->created])
            . '/' . lang('Tables.updated') . ': ' . lang('{updated, date} {updated, time}', ['updated' => $category->updated]) ?>
        </span>
  </div>
</div>

<div class="row">
  <div class="input-field col s12 m8">
    <input name="name"
           class="validate"
           required
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           id="name"
           type="text"
           value="<?= old('name', $category->name) ?>"/>
    <label for="name"><?= lang('Tables.categories.name') ?></label>
  </div>
  <div class="input-field col s12 m2">
    <label>
      <input name="is_system"
          <?= ($options['disabled']) ? 'disabled' : '' ?>
             type="checkbox"
             value="1"
          <?= (old('is_system', $category->is_system)) ? 'checked' : '' ?> />
      <span><?= lang('Tables.categories.is_system') ?></span>
    </label>
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
        <textarea id="description"
                  <?= ($options['disabled']) ? 'disabled' : '' ?>
                  name="description"
                  class="materialize-textarea"><?= old('description', $category->description) ?></textarea>
    <label for="description"><?= lang('Tables.categories.description') ?></label>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <a href="/admin/<?= $controller ?>"
       class="btn waves-effect waves-light"><?= lang('General.back') ?>
      <i class="material-icons left">arrow_back</i></a>
      <?php
      if (!$options['disabled']) : ?>
        <button type="submit" class="btn waves-effect waves-light"><?= lang('General.submit') ?>
          <i class="material-icons right">send</i></button>
      <?php
      endif; ?>
  </div>
</div>