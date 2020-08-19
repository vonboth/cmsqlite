<div class=""
     :class="{hide: hideMenuForm}"
     id="menu-form">
  <form ref="menu_form" method="post" :action="menuFormAction">
    <?= csrf_field() ?>
    <div class="card">
      <div class="progress" :class="{hide: !(isLoading)}">
        <div class="indeterminate"></div>
      </div>
      <div class="card-content">
        <div class="row">
          <div class="col s12">
            <div>
              <label for="name"><?= lang('Tables.menus.name') ?></label>
              <input type="text"
                     v-model="selectedMenu.name"
                     id="name"
                     required
                     class="validate"
                     name="name"/>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col s12">
            <div>
              <label for="name"><?= lang('Tables.menus.description') ?></label>
              <input type="text"
                     v-model="selectedMenu.description"
                     id="description"
                     class="validate"
                     name="description"/>
            </div>
          </div>
        </div>

      </div>
      <div class="card-action">
        <button class="btn waves-effect waves-light"
                @click="onCancelEditMenu"
                type="button"><?= lang('General.cancel') ?>
          <i class="material-icons right">cancel</i></button>
        <button class="btn waves-light waves-effect"
                v-bind:disabled="!(canSaveMenu)"
                @click="onSaveMenu"
                type="button"><?= lang('General.submit') ?>
          <i class="material-icons right">send</i></button>
      </div>
    </div>
  </form>
</div>