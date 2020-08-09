<?php
/** @var \App\Models\Entities\Article $article */

?>
<!-- Some information related to the article -->
<div class="row">
  <div class="col s12 <?= (is_null($article->id) ? 'hide' : '') ?>">
        <span class="right">
            <?= lang('Tables.articles.published') . ': '
            . (($article->published) ? lang('General.yes') : lang('General.no'))
            . ' / ' . lang('Tables.created') . ': ' . $article->created
            . '/' . lang('Tables.updated') . ': ' . $article->updated ?>
        </span>
  </div>
</div>

<div class="row">
  <div class="input-field col s12 m8">
    <input name="title"
           required
           class="validate"
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           id="title"
           type="text"
           value="<?= esc(old('title', $article->title)) ?>"/>
    <label for="title"><?= lang('Tables.articles.title') ?></label>
  </div>
  <div class="input-field col s12 m2">
    <label>
      <input name="is_startpage"
          <?= ($options['disabled']) ? 'disabled' : '' ?>
             type="checkbox"
             value="1" <?= (old('is_startpage', $article->is_startpage)) ? 'checked' : '' ?>/>
      <span><?= lang('Tables.articles.is_startpage') ?></span>
    </label>
  </div>
  <div class="input-field col s12 m2">
    <label>
      <input name="published"
          <?= ($options['disabled']) ? 'disabled' : '' ?>
             type="checkbox"
             value="1" <?= (old('published', $article->published)) ? 'checked' : '' ?> />
      <span><?= lang('Tables.articles.published') ?></span>
    </label>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <h5><?= lang('Tables.articles.content') ?></h5>
    <div>
                <textarea name="content"
                          rows="30"
                          ref="CKEditor"
                          <?= ($options['disabled']) ? 'disabled' : '' ?>
                          id="editor"><?= old('content', $article->content) ?></textarea>
    </div>
  </div>
</div>

<ul class="collapsible">
  <li>
    <div class="collapsible-header">
      <i class="material-icons">add_circle_outline</i><?= lang('Tables.articles.additional_information') ?></div>
    <div class="collapsible-body">

      <div class="row">
        <div class="input-field col s12 m6">
          <input name="alias"
              <?= ($options['disabled']) ? 'disabled' : '' ?>
                 id="alias"
                 type="text"
                 value="<?= esc(old('alias', $article->alias)) ?>"/>
          <label for="alias"><?= lang('Tables.articles.alias') ?></label>
        </div>

        <div class="input-field col s12 m6">
          <input name="doc_key"
              <?= ($options['disabled']) ? 'disabled' : '' ?>
                 id="doc_key"
                 type="text"
                 value="<?= esc(old('doc_key', $article->doc_key)) ?>"/>
          <label for="doc_key"><?= lang('Tables.articles.doc_key') ?></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12">
        <textarea id="description"
                  <?= ($options['disabled']) ? 'disabled' : '' ?>
                  class="materialize-textarea"
                  placeholder="<?= lang('Tables.articles.description') ?>">
            <?= esc(old('description', $article->description)) ?>
        </textarea>
          <label for="description"><?= lang('Tables.articles.description') ?></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6">
          <input name="start_publish"
                 class="datepicker"
              <?= ($options['disabled']) ? 'disabled' : '' ?>
                 id="start_publish"
                 type="text"
                 value="<?= old('start_publish', $article->start_publish) ?>"/>
          <label for="start_publish"><?= lang('Tables.articles.start_publish') ?></label>
        </div>
        <div class="input-field col s12 m6">
          <input name="stop_publish"
                 class="datepicker"
              <?= ($options['disabled']) ? 'disabled' : '' ?>
                 id="stop_publish"
                 type="text"
                 value="<?= old('stop_publish', $article->stop_publish) ?>"/>
          <label for="stop_publish"><?= lang('Tables.articles.stop_publish') ?></label>
        </div>
      </div>
    </div>
  </li>
</ul>

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