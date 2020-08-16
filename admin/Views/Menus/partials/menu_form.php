<form>
  <div class="card">
    <div class="card-content">
      <div class="row">
        <div class="col s12">
          <div class="input-field">
            <input type="text"
                   id="name"
                   required
                   class="validate"
                   name="name" />
            <label for="name"><?= lang('Tables.menus.name') ?></label>
          </div>
        </div>
      </div>
    </div>
    <div class="card-action">
      <button class="btn" type="button">
        <i class="material-icons">cancel</i> <?= lang('General.cancel') ?>
      </button>
      <button class="btn" type="button">
        <i class="material-icons">send</i> <?= lang('General.submit') ?>
      </button>
    </div>
  </div>
</form>