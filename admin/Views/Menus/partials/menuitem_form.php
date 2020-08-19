<?php
/** @var $menus */
/** @var $articles */
/** @var $menuitems */
?>
<div class="hide" ref="menuitem-form">
  <form ref="menuitem-form" method="post" action="/admin/menuitems/add">
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
               v-model="selectedMenuItem.title"/>
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
                v-model="selectedMenuItem.type"
                name="type">
          <option value="article"><?= lang('Tables.menuitems.article') ?></option>
          <option value="other"><?= lang('Tables.menuitems.other') ?></option>
        </select>
      </div>
    </div>

    <div class="row" :class="{hide: selectedMenuItem.type !== 'article'}">
      <div class="col s12">
        <label for="article_id"><?= lang('Tables.menuitems.article_id') ?>
          <span class="helper-text">
                      <i class="material-icons tooltipped" data-position="right"
                         data-tooltip="<?= lang('Help.menus.article_id') ?>">help_outline</i>
                    </span>
        </label>
        <select id="article_id"
                class="no-material"
                v-model="selectedMenuItem.article_id"
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
    <div class="row" :class="{hide: selectedMenuItem.type !== 'other'}">
      <div class="col s12">
        <label for="url"><?= lang('Tables.menuitems.url') ?>
          <span class="helper-text">
                      <i class="material-icons tooltipped" data-position="right"
                         data-tooltip="<?= lang('Help.menus.url') ?>">help_outline</i>
                    </span>
        </label>
        <input name="url" id="url" required type="text" v-model="selectedMenuItem.url"/>
      </div>
    </div>

    <!--div class="row">
                <div class="col s12">
                  <label for="menu_id"><?= lang('Tables.menuitems.menu_id') ?>
                    <span class="helper-text">
                      <i class="material-icons tooltipped" data-position="right"
                         data-tooltip="<?= lang('Help.menus.menu') ?>">help_outline</i>
                    </span>
                  </label>
                  <select name="menu_id"
                          required
                          class="no-material"
                          id="menu_id"
                          v-model="selectedMenuItem.menu_id">
                      <?php
    foreach ($menus as $selectMenu): ?>
                        <option value="<?= $selectMenu->id ?>"><?= $selectMenu->name ?></option>
                      <?php
    endforeach; ?>
                  </select>
                </div>
              </div-->

    <div class="row">
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
                v-model="selectedMenuItem.parent_id">
            <?php
            foreach ($menuitems as $menuitem): ?>
              <option value="<?= $menuitem->id ?>"><?= $menuitem->title ?></option>
            <?php
            endforeach; ?>
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
        <input type="text" v-model="selectedMenuItem.alias"
               name="alias" id="alias"/>
      </div>
    </div>

    <div class="row">
      <div class="col s12">
        <label for="layout"><?= lang('Tables.menuitems.layout') ?>
          <span class="helper-text">
                      <i class="material-icons tooltipped" data-position="right"
                         data-tooltip="<?= lang('Help.menus.title') ?>">help_outline</i>
                    </span>
        </label>
        <input type="text" v-model="selectedMenuItem.layout"
               name="layout" id="layout" value="default"/>
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
                v-model="selectedMenuItem.target">
          <option value="_blank">_blank</option>
          <option value="_parent">_parent</option>
          <option value="_self">_self</option>
          <option value="_top">_top</option>
        </select>
      </div>
    </div>

  </form>
</div>
