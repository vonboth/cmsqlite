<?php
/** @var \App\Models\Entities\Article $article */

?>
    <!-- Some information related to the article -->
    <div class="row">
        <div class="col s12 <?= (is_null($article->id)) ? 'hide' : '' ?>">
        <span class="right">
            <?= lang('Tables.articles.published') . ': '
            . (($article->published) ? lang('General.yes') : lang('General.no'))
            . ' / ' . lang('Tables.created') . ': ' . $article->created
            . '/' . lang('Tables.updated') . ': ' . $article->updated ?>
        </span>
        </div>
    </div>

<?= form_open('/admin/articles/add', 'class="col s12"') ?>
    <div class="row">
        <div class="input-field col s12 m8">
            <input name="title"
                   required
                <?= ($options['disabled']) ? 'disabled' : '' ?>
                   id="title"
                   type="text"
                   value="<?= esc($article->title) ?>"/>
            <label for="title"><?= lang('Tables.articles.title') ?></label>
        </div>
        <div class="input-field col s12 m2">
            <label>
                <input name="is_startpage"
                    <?= ($options['disabled']) ? 'disabled' : '' ?>
                       type="checkbox"
                       value="1" <?= ($article->is_startpage) ? 'checked' : '' ?>/>
                <span><?= lang('Tables.articles.is_startpage') ?></span>
            </label>
        </div>
        <div class="input-field col s12 m2">
            <label>
                <input name="published"
                    <?= ($options['disabled']) ? 'disabled' : '' ?>
                       type="checkbox"
                       value="1" <?= ($article->published) ? 'checked' : '' ?> />
                <span><?= lang('Tables.articles.published') ?></span>
            </label>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <h5><?= lang('Tables.articles.content') ?></h5>
            <div>
                <textarea name="article"
                          <?= ($options['disabled']) ? 'disabled' : '' ?>
                          class=""
                          id="editor"></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12 m6">
            <input name="alias"
                <?= ($options['disabled']) ? 'disabled' : '' ?>
                   id="alias"
                   type="text"
                   value="<?= esc($article->alias) ?>"/>
            <label for="alias"><?= lang('Tables.articles.alias') ?></label>
        </div>

        <div class="input-field col s12 m6">
            <input name="doc_key"
                <?= ($options['disabled']) ? 'disabled' : '' ?>
                   id="doc_key"
                   type="text"
                   value="<?= esc($article->doc_key) ?>"/>
            <label for="doc_key"><?= lang('Tables.articles.doc_key') ?></label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12">
        <textarea id="description"
                  <?= ($options['disabled']) ? 'disabled' : '' ?>
                  class="materialize-textarea"
                  placeholder="<?= lang('Tables.articles.description') ?>"></textarea>
            <label for="description"><?= $article->description ?></label>
        </div>
    </div>

    <div class="row">
        <div class="input-field col s12 m6">
            <input name="start_publish"
                <?= ($options['disabled']) ? 'disabled' : '' ?>
                   id="start_publish"
                   type="text"
                   value="<?= $article->start_publish ?>"/>
            <label for="start_publish"><?= lang('Tables.articles.start_publish') ?></label>
        </div>
        <div class="input-field col s12 m6">
            <input name="stop_publish"
                <?= ($options['disabled']) ? 'disabled' : '' ?>
                   id="stop_publish"
                   type="text"
                   value="<?= $article->stop_publish ?>"/>
            <label for="stop_publish"><?= lang('Tables.articles.stop_publish') ?></label>
        </div>
    </div>
<?= form_close() ?>
