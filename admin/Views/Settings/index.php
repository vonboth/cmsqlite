<?php

$this->extend('AdminThemes\default\layouts\default');
$this->section('main'); ?>
  <div class="row">
    <div class="col s12">
      <a href="javascript:void(0)"
         @click="onAddNewSetting"
         class="btn-floating waves-effect waves-light blue">
        <i class="material-icons">add</i>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-content">
      <div>
          <?php
          foreach ($settings as $setting): ?>
            <div class="row">
              <div class="input-field col s6">
                <input type="text"
                       id="id-<?= $setting->name ?>"
                       class="settings-input"
                       disabled
                       v-bind:disabled="editSettingId !== <?= $setting->id ?>"
                       name="<?= $setting->name ?>"
                       value="<?= $setting->value ?>"/>
                <label for="id-<?= $setting->name ?>"><?= $setting->name ?></span></label>
              </div>
              <div class="col s2 input-field pt1">
                <div class="inline-block" v-bind:class="{hide: editSettingId === <?= $setting->id ?>}">
                  <a href="javascript:void(0)"
                     title="<?= lang('General.edit') ?>"
                     @click="onEditSetting(<?= $setting->id ?>, '<?= $setting->name ?>')">
                    <i class="material-icons">edit</i></a>
                  <a href="javascript:void(0)"
                     title="<?= lang('General.edit') ?>"
                     @click="onDeleteSetting(<?= $setting->id ?>)">
                    <i class="material-icons">delete</i></a>
                </div>
                <div class="inline-block" v-bind:class="{hide: editSettingId !== <?= $setting->id ?>}">
                  <a href="javascript:void(0)"
                     title="<?= lang('General.cancel') ?>"
                     @click="onCancelEditSetting('<?= $setting->name ?>')">
                    <i class="material-icons">cancel</i></a>
                  <a href="javascript:void(0)"
                     title="<?= lang('General.save') ?>"
                     @click="onSaveSetting(<?= $setting->id ?>, '<?= $setting->name ?>')">
                    <i class="material-icons">save</i></a>
                </div>
              </div>
            </div>
          <?php
          endforeach; ?>
      </div>
      <form method="post" action="/admin/settings/add">
          <?= csrf_field() ?>
        <div v-bind:class="{'hide': !(addNewSetting)}">
          <div class="row">
            <div class="input-field col s5">
              <input type="text" name="name" id="new_name"/>
              <label for="new_name"><?= lang('Tables.settings.name') ?></label>
            </div>
            <div class="input-field col s5">
              <input type="text" name="value" id="new_value"/>
              <label for="new_value"><?= lang('Tables.settings.value') ?></label>
            </div>
            <div class="col s2 input-field pt1">
              <div class="inline-block">
                <a href="javascript:void(0)" @click="onCancelNewSetting">
                  <i class="material-icons">cancel</i>
                </a>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col s12">
              <button type="submit" class="btn waves-light waves-effect"><?= lang('General.submit') ?>
                <i class="material-icons right">send</i></button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
<?php
$this->endSection();
?>