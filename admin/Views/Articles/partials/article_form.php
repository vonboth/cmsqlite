<?php
/** @var array $article */

/** @var Admin\Models\Entities\Category[] $categories */
/** @var bool $formDisabled */
/** @var string $controller */
/** @var string $theme */
/** @var string $language default language set in DB-Settings */
/** @var int $translations translations enabled set in DB-Settings */
/** @var string[] $supportedTranslations */
/** @var string[] $layouts */
$supportedTranslations = array_diff(config('Admin\Config\SystemSettings')->supportedTranslations, [$language]);
?>
<div class="row">
    <?php
    if ($translations): ?>
        <div class="col s12">
            <ul class="tabs">
                <li class="tab col s2">
                    <a class="active" href="#tab_<?= $language ?>"><?= $language ?></a>
                </li>
                <?php
                foreach ($supportedTranslations as $lang): ?>
                    <li class="tab col s2"><a href="#tab_<?= $lang ?>"><?= $lang ?></a></li>
                <?php
                endforeach; ?>
            </ul>
        </div>
    <?php
    endif; ?>
    <div id="tab_<?= $language ?>" class="col s12">
        <!-- Some information related to the article -->
        <div class="row">
            <div class="col s12 <?= (is_null($article['id']) ? 'hide' : '') ?>">
                <span class="right">
                    <?= 'ID: ' . $article['id']
                    . ' | ' . lang('admin.tables.articles.published') . ': ' . (($article['published']) ? lang(
                        'General.yes'
                    ) : lang(
                        'General.no'
                    ))
                    . ' | ' . lang('admin.created') . ': ' . lang(
                        '{created, date} {created, time}',
                        ['created' => $article['created'] ?? new DateTime()]
                    )
                    . ' | ' . lang('admin.updated') . ': ' . lang(
                        '{updated, date} {updated, time}',
                        ['updated' => $article['updated'] ?? new DateTime()]
                    ) ?>
                </span>
            </div>
        </div>

        <div class="row">
            <div class="input-field col s12 m8">
                <input name="title"
                       required
                       class="validate"
                    <?= ($formDisabled) ? 'disabled' : '' ?>
                       id="title"
                       type="text"
                       value="<?= esc(old('title', $article['title'])) ?>"/>
                <label for="title"><?= lang('admin.tables.title') ?></label>
            </div>

            <div class="input-field col s12 m2">
                <label>
                    <input name="is_startpage"
                        <?= ($formDisabled) ? 'disabled' : '' ?>
                           type="checkbox"
                           value="1" <?= (old('is_startpage', $article['is_startpage'])) ? 'checked' : '' ?>/>
                    <span><?= lang('admin.tables.articles.is_startpage') ?></span>
                </label>
            </div>

            <div class="input-field col s12 m2">
                <label>
                    <input type="hidden" name="published" value="0"/>
                    <input name="published"
                        <?= ($formDisabled) ? 'disabled' : '' ?>
                           type="checkbox"
                           value="1" <?= (old('published', $article['published'])) ? 'checked' : '' ?> />
                    <span><?= lang('admin.tables.articles.published') ?></span>
                </label>
            </div>
        </div>

        <div class="row">
            <div class="col s12">
                <h5><?= lang('admin.tables.articles.content') ?></h5>
                <div>
                    <jodit-editor id="content"
                                  name="content"
                                  :disabled="<?= $formDisabled ? 'true' : 'false' ?>">
                        <?= esc($article['content']) ?>
                    </jodit-editor>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="input-field col m4 s12">
                <?= form_dropdown(
                    'category_id',
                    ['' => '-'] + $categories,
                    $article['category_id'],
                    ($formDisabled) ? 'disabled' : ''
                ) ?>
                <label><?= lang('admin.tables.categories.category') ?></label>
            </div>
            <div class="input-field col m4 s12">
                <select name="layout" id="layout">
                    <option value="">-</option>
                    <?php
                    foreach ($layouts as $layout): ?>
                        <option value="<?= strtolower($layout) ?>" <?= $article['layout'] === $layout ? 'selected' : '' ?>>
                            <?= strtolower($layout) ?>
                        </option>
                    <?php
                    endforeach; ?>
                </select>
                <label for="layout"><?= lang('admin.tables.articles.layout') ?></label>
            </div>
        </div>

        <ul class="collapsible simple">
            <li>
                <div class="collapsible-header">
                    <i class="material-icons">add_circle_outline</i><?= lang(
                        'admin.tables.articles.additional_information'
                    ) ?>
                </div>
                <div class="collapsible-body">
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input name="alias"
                                   <?= ($formDisabled) ? 'disabled' : '' ?>
                                   id="alias"
                                   type="text"
                                   value="<?= esc(old('alias', $article['alias'])) ?>"/>
                            <label for="alias"><?= lang('admin.tables.alias') ?></label>
                        </div>

                        <div class="input-field col s12 m4">
                            <input name="doc_key"
                                   <?= ($formDisabled) ? 'disabled' : '' ?>
                                   id="doc_key"
                                   type="text"
                                   value="<?= esc(old('doc_key', $article['doc_key'])) ?>"/>
                            <label for="doc_key"><?= lang('admin.tables.articles.doc_key') ?></label>
                        </div>

                        <div class="input-field col s12 m4">
                            <input name="class"
                                   <?= ($formDisabled) ? 'disabled' : '' ?>
                                   id="class"
                                   type="text"
                                   value="<?= esc(old('class', $article['class'])) ?>"/>
                            <label for="class"><?= lang('admin.tables.articles.class') ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <textarea id="description"
                                      name="description"
                                      <?= ($formDisabled) ? 'disabled' : '' ?>
                                      class="materialize-textarea"
                                      placeholder="<?= lang('admin.tables.description') ?>"><?=
                                esc(old('description', $article['description'])) ?></textarea>
                            <label for="description"><?= lang('admin.tables.description') ?></label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input name="start_publish"
                                   class="datepicker"
                                   <?= ($formDisabled) ? 'disabled' : '' ?>
                                   id="start_publish"
                                   type="text"
                                   value="<?= old('start_publish', $article['start_publish']) ?>"/>
                            <label for="start_publish"><?= lang('admin.tables.articles.start_publish') ?></label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="stop_publish"
                                   class="datepicker"
                                   <?= ($formDisabled) ? 'disabled' : '' ?>
                                   id="stop_publish"
                                   type="text"
                                   value="<?= old('stop_publish', $article['stop_publish']) ?>"/>
                            <label for="stop_publish"><?= lang('admin.tables.articles.stop_publish') ?></label>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <?php
    if ($translations): ?>
        <?php
        $idx = 0;
        foreach ($supportedTranslations as $lang): ?>
            <div id="tab_<?= $lang ?>" class="col s12">
                <input type="hidden"
                       name="translations[<?= $idx ?>][article_id]"
                       value="<?= $article['translations'][$lang]['article_id'] ?? $article['id'] ?>"/>
                <input type="hidden"
                       name="translations[<?= $idx ?>][id]"
                       value="<?= $article['translations'][$lang]['id'] ?? '' ?>"/>
                <input type="hidden"
                       name="translations[<?= $idx ?>][language]"
                       value="<?= $article['translations'][$lang]['lang'] ?? $lang ?>"/>

                <div class="row">
                    <div class="col s12 <?= (is_null($article['translations'][$lang]['id']) ? 'hide' : '') ?>">
                        <span class="right">
                            <?= 'ID: ' . $article['translations'][$lang]['id']
                            . ' | ' . lang('admin.created') . ': ' . lang(
                                '{created, date} {created, time}',
                                ['created' => $article['translations'][$lang]['created'] ?? new DateTime()]
                            )
                            . ' | ' . lang('admin.updated') . ': ' . lang(
                                '{updated, date} {updated, time}',
                                ['updated' => $article['translations'][$lang]['updated'] ?? new DateTime()]
                            ) ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12 m8">
                        <input name="translations[<?= $idx ?>][title]"
                               required
                               class="validate"
                            <?= ($formDisabled) ? 'disabled' : '' ?>
                               id="title_<?= $lang ?>"
                               type="text"
                               value="<?= esc(old('title', $article['translations'][$lang]['title'])) ?>"/>
                        <label for="title"><?= lang('admin.tables.title') ?></label>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <h5><?= lang('admin.tables.articles.content') ?></h5>
                        <div>
                            <jodit-editor theme="<?= $theme ?>"
                                    id="content_<?= $lang ?>"
                                    name="translations[<?= $idx ?>][content]"
                                    :disabled="<?= $formDisabled ? 'true' : 'false' ?>">
                                <?= empty($article['translations'][$lang]['content'])
                                    ? esc($article['content'])
                                    : esc($article['translations'][$lang]['content']) ?>
                            </jodit-editor>
                        </div>
                    </div>
                </div>

                <ul class="collapsible simple">
                    <li>
                        <div class="collapsible-header">
                            <i class="material-icons">add_circle_outline</i><?= lang(
                                'admin.tables.articles.additional_information'
                            ) ?>
                        </div>
                        <div class="collapsible-body">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input name="translations[<?= $idx ?>][alias]"
                                        <?= ($formDisabled) ? 'disabled' : '' ?>
                                           id="alias_<?= $lang ?>"
                                           type="text"
                                           value="<?= esc(old('alias', $article['translations'][$lang]['alias'])) ?>"/>
                                    <label for="alias"><?= lang('admin.tables.alias') ?></label>
                                </div>

                                <div class="input-field col s12 m6">
                                    <input name="translations[<?= $idx ?>][doc_key]"
                                        <?= ($formDisabled) ? 'disabled' : '' ?>
                                           id="doc_key_<?= $lang ?>"
                                           type="text"
                                           value="<?= esc(
                                               old('doc_key', $article['translations'][$lang]['doc_key'])
                                           ) ?>"/>
                                    <label for="doc_key"><?= lang('admin.tables.articles.doc_key') ?></label>
                                </div>
                            </div>

                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description_<?= $lang ?>"
                                              name="translations[<?= $idx ?>][description]"
                                              <?= ($formDisabled) ? 'disabled' : '' ?>
                                              class="materialize-textarea"
                                              placeholder="<?= lang('admin.tables.description') ?>"><?=
                                        esc(
                                            old('description', $article['translations'][$lang]['description'])
                                        ) ?></textarea>
                                    <label for="description"><?= lang('admin.tables.description') ?></label>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
            <?php
            $idx++;
        endforeach; ?>

    <?php
    endif; ?>
</div>

<div class="row">
    <div class="col s12">
        <a href="/admin/<?= $controller ?>"
           class="btn waves-effect waves-light"><?= lang('admin.back') ?>
            <i class="material-icons left">arrow_back</i></a>
        <a href="/admin/articles/add"
           class="btn waves-effect waves-light ml1rem"><?= lang('admin.new') ?>
            <i class="material-icons left">add</i></a>
        <?php
        if (!$formDisabled) : ?>
            <button type="button"
                    onclick="onSubmit()"
                    class="btn waves-effect waves-light ml1rem"><?= lang('admin.save') ?>
                <i class="material-icons right">send</i></button>
        <?php
        endif; ?>
    </div>
</div>

<?php
$this->section('js') ?>
<script type="text/javascript">
    function onSubmit() {
        let hasError = false;
        const inputs = document.querySelectorAll('input[required]');

        for (let input of inputs) {
            if (!input.value) {
                input.classList.add('validate');
                input.classList.add('invalid');
                hasError = true;
            }
        }

        if (!hasError) {
            document.querySelector('form').submit();
        } else {
            M.toast({html: '<?= lang('admin.validation.check_required') ?>'});
        }
    }
</script>
<?php
$this->endSection() ?>
