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
              <option value="other"><?= lang('Tables.menuitems.other') ?></option>
            </select>
          </div>
        </div>

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
               data-tooltip="<?= lang('Help.menus.parent_item') ?>">help_outline</i>
          </span>
            </label>
            <select name="parent_id"
                    class="no-material"
                    id="parent_id"
                    v-model="selectedMenuitem.parent_id">
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
            <input type="text" v-model="selectedMenuitem.alias"
                   name="alias" id="alias"/>
          </div>
        </div>

        <!--div class="row">
          <div class="col s12">
            <label for="layout"><?= lang('Tables.menuitems.layout') ?>
              <span class="helper-text">
            <i class="material-icons tooltipped" data-position="right"
               data-tooltip="<?= lang('Help.menus.title') ?>">help_outline</i>
          </span>
            </label>
            <input type="text" v-model="selectedMenuitem.layout"
                   name="layout" id="layout" value="default"/>
          </div>
        </div-->

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
              <option value="_blank">_blank</option>
              <option value="_parent">_parent</option>
              <option value="_self">_self</option>
              <option value="_top">_top</option>
            </select>
          </div>
        </div>
      </div>
      <div class="card-action">
        <button class="btn waves-effect waves-light"
                @click="onCancelEditMenuitem"
                type="button"><?= lang('General.cancel') ?>
          <i class="material-icons right">cancel</i></button>
        <button class="btn waves-light waves-effect"
                v-bind:disabled="!(canSaveMenuitem)"
                @click="onSaveMenuitem"
                type="button"><?= lang('General.submit') ?>
          <i class="material-icons right">send</i></button>
      </div>
    </div>
  </form>
</div>
