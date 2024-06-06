<?php
/** @var string $theme */
/** @var \Admin\Models\Entities\User $user */

$this->extend("AdminThemes\\$theme\\layouts\\default");
$this->section('main'); ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="card mh65vh">
  <div class="card-content">
    <div class="row">
      <?= form_open('/admin/profile/edit', 'class="col s12"') ?>
      <div class="row">
        <div class="input-field col s12 m6">
          <input type="hidden" name="id" value="<?= $user['id'] ?>">
          <input id="firstname"
                 name="firstname"
                 required="required"
                 value="<?= old('firstname', $user['firstname']) ?>"
                 type="text"
                 class="validate">
          <label for="firstname"><?= lang('Tables.users.firstname') ?></label>
        </div>
        <div class="input-field col s12 m6">
          <input id="lastname"
                 name="lastname"
                 value="<?= old('lastname', $user['lastname']) ?>"
                 type="text">
          <label for="lastname"><?= lang('Tables.users.lastname') ?></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6">
          <input id="email"
                 name="email"
                 value="<?= old('email', $user['email']) ?>"
                 type="text"
                 required="required"
                 class="validate">
          <label for="email"><?= lang('Table.users.email') ?></label>
        </div>
      </div>

      <div class="row">
        <div class="input-field col s12 m6">
          <input id="password"
                 name="password"
                 type="password"
                 class="validate">
          <label for="password"><?= lang('Tables.users.password') ?></label>
        </div>

        <div class="input-field col s12 m6">
          <input id="password-confirm"
                 name="password_confirm"
                 type="password"
                 class="validate">
          <label for="password-confirm"><?= lang('Tables.users.confirm_password') ?></label>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <a href="/admin"
             class="btn waves-effect waves-light"><?= lang('General.back') ?>
            <i class="material-icons left">arrow_back</i></a>
          <button type="submit" class="btn waves-effect waves-light ml1rem"><?= lang('General.submit') ?>
            <i class="material-icons right">send</i></button>
        </div>
      </div>

      <?= form_close() ?>
    </div>
  </div>
</div>
</div>

<?php
$this->endSection() ?>
