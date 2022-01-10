<?php
/** @var \Admin\Models\Entities\Article[] $articles a list of all articles */

/** @var \Admin\Models\Entities\Category[] $categories a list of categories */
?>
<div class="" :class="{hide: hideMenuitemForm}">
  <form ref="menuitem_form" method="post" :action="menuitemFormAction">
    <?= csrf_field() ?>
    <input type="hidden" name="menu_id" v-model="selectedMenuitem.menu_id"/>
    <input type="hidden" name="lft" v-model="selectedMenuitem.lft"/>
    <input type="hidden" name="rgt" v-model="selectedMenuitem.rgt"/>

    <div class="card">
      <div class="progress" :class="{hide: !(isLoading)}">
        <div class="indeterminate"></div>
      </div>
      <div class="card-content">
        <!-- TITLE -->
        <div class="row">
          <div class="col s12">
            <label for="title"><?= lang('Tables.menuitems.title') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.title') ?>">help_outline</i>
              </span>
            </label>
            <input name="title"
                   required
                   @keyup="onChangeMenuitemTitle"
                   id="title"
                   type="text"
                   v-model="selectedMenuitem.title"/>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <label for="type"><?= lang('Tables.menuitems.type') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.type') ?>">help_outline</i>
              </span>
            </label>
            <select id="type"
                    class="no-material"
                    @change="onChangeMenuitemType"
                    v-model="selectedMenuitem.type"
                    name="type">
              <option value="article"><?= lang('Tables.menuitems.article') ?></option>
              <!--option value="category"><?= lang('Tables.menuitems.category') ?></option-->
              <option value="other"><?= lang('Tables.menuitems.other') ?></option>
            </select>
          </div>
        </div>

        <!-- article selector -->
        <div class="row" :class="{hide: selectedMenuitem.type !== 'article'}">
          <div class="col s12">
            <label for="article_id"><?= lang('Tables.menuitems.article_id') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.article_id') ?>">help_outline</i>
              </span>
            </label>
            <select id="article_id"
                    class="no-material"
                    v-model="selectedMenuitem.article_id"
                    name="article_id">
              <?php
              foreach ($articles as $article): ?>
                <option value="<?= $article->id ?>"><?= $article->title ?></option>
              <?php
              endforeach; ?>
            </select>
          </div>
        </div>

        <!-- category selector -->
        <div class="row" :class="{hide: selectedMenuitem.type !== 'category'}">
          <div class="col s12">
            <label for="category_id"><?= lang('Tables.menuitems.category_id') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.category_id') ?>">help_outline</i>
              </span>
            </label>
            <select id="category_id"
                    class="no-material"
                    v-model="selectedMenuitem.category_id"
                    v-bind:required="selectedMenuitem.type === 'category'"
                    name="category_id">
              <option value="">-</option>
              <?php
              foreach ($categories as $category): ?>
                <option value="<?= $category->id ?>"><?= $category->name ?></option>
              <?php
              endforeach; ?>
            </select>
          </div>
        </div>

        <!-- URL -->
        <div class="row" :class="{hide: selectedMenuitem.type !== 'other'}">
          <div class="col s12">
            <label for="url"><?= lang('Tables.menuitems.url') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.url') ?>">help_outline</i>
              </span>
            </label>
            <input name="url" id="url" type="text" v-model="selectedMenuitem.url"/>
          </div>
        </div>

        <div class="row" :class="{hide: selectedMenuitem.id}">
          <div class="col s12">
            <label for="parent_id"><?= lang('Tables.menuitems.parent_id') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.parent_id') ?>">help_outline</i>
              </span>
            </label>
            <select name="parent_id"
                    class="no-material"
                    id="parent_id"
                    v-model="selectedMenuitem.parent_id">
              <option value="">-</option>
              <option v-for="item in parentMenus"
                      v-bind:value="item.id"
                      v-text="item.title"></option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <label for="alias"><?= lang('Tables.menuitems.alias') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.alias') ?>">help_outline</i>
              </span>
            </label>
            <input type="text"
                   v-model="selectedMenuitem.alias"
                   name="alias"
                   id="alias"/>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <label for="target"><?= lang('Tables.menuitems.target') ?>
              <span class="helper-text">
                <i class="material-icons tooltipped" data-position="right"
                   data-tooltip="<?= lang('Help.menus.target') ?>">help_outline</i>
              </span>
            </label>
            <select name="target"
                    class="no-material"
                    id="target"
                    v-model="selectedMenuitem.target">
              <option value="_self"><?= lang('Menu.self') ?></option>
              <option value="_blank"><?= lang('Menu.blank') ?></option>
              <!--option value="_parent">_parent</option-->
              <!--option value="_top">_top</option-->
            </select>
          </div>
        </div>

        <ul class="collapsible simple">
          <li>
            <div class="collapsible-header">
              <i class="material-icons">add_circle_outline</i><?= lang('Tables.menuitems.additional_settings') ?>
            </div>
            <div class="collapsible-body">
              <div class="row">
                <div class="col s12">
                  <label for="li_class"><?= lang('Tables.menuitems.li_class') ?>
                    <span class="helper-text">
                      <i class="material-icons tooltipped" data-position="right"
                         data-tooltip="<?= lang('Help.menus.li_class') ?>">help_outline</i>
                    </span>
                  </label>
                  <input id="li_class"
                         v-model="selectedMenuitem.li_class"
                         type="text"
                         name="li_class"/>
                </div>
              </div>

              <div class="row">
                <div class="col s12">
                  <label for="li_attributes"><?= lang('Tables.menuitems.li_attributes') ?>
                    <span class="helper-text">
                      <i class="material-icons tooltipped"
                         data-position="right"
                         data-tooltip="<?= lang('Help.menus.li_attributes') ?>">help_outline</i>
                    </span>
                  </label>
                  <input id="li_attributes"
                         v-model="selectedMenuitem.li_attributes"
                         type="text"
                         name="li_attributes"/>
                </div>
              </div>

              <div class="row">
                <div class="col s12">
                  <label for="a_class"><?= lang('Tables.menuitems.a_class') ?>
                    <span class="helper-text">
                      <i class="material-icons tooltipped"
                         data-position="right"
                         data-tooltip="<?= lang('Help.menus.a_class') ?>">help_outline</i>
                    </span>
                  </label>
                  <input id="a_class"
                         v-model="selectedMenuitem.a_class"
                         type="text"
                         name="a_class"/>
                </div>
              </div>

              <div class="row">
                <div class="col s12">
                  <label for="a_attributes"><?= lang('Tables.menuitems.a_attributes') ?>
                    <span class="helper-text">
                      <i class="material-icons tooltipped"
                         data-position="right"
                         data-tooltip="<?= lang('Help.menus.a_attributes') ?>">help_outline</i>
                    </span>
                  </label>
                  <input id="a_attributes"
                         v-model="selectedMenuitem.a_attributes"
                         type="text"
                         name="a_attributes"/>
                </div>
              </div>
            </div>
          </li>
        </ul>

      </div>

      <div class="card-action">
        <button class="btn waves-effect waves-light"
                @click="onCancelEditMenuitem"
                type="button"><?= lang('General.cancel') ?>
          <i class="material-icons right">cancel</i></button>
        <button class="btn waves-light waves-effect"
                v-bind:disabled="!(canSaveMenuitem)"
                @click="onSaveMenuitem"
                type="button"><?= lang('General.save') ?>
          <i class="material-icons right">send</i></button>
      </div>
    </div>
  </form>
</div>
