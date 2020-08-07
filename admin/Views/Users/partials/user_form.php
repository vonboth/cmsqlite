<?php
/** @var \Admin\Models\Entities\Category $user */

?>
<div class=row>
  <div class="col s12 <?= (is_null($user->id) ? 'hide' : '') ?>">
        <span class="right">
            <?= lang('Tables.created') . ': ' . $user->created
            . '/' . lang('Tables.updated') . ': ' . $user->updated ?>
        </span>
  </div>
</div>

<div class="row">
  <div class="input-field col s6">
    <input id="username"
           name="username"
           value="<?= old('username', $user->username) ?>"
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           type="text"
           class="validate"
           required="required">
    <label for="username"><?= lang('username') ?></label>
  </div>
  <div class="input-field col s6">
    <input id="email"
           name="email"
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           value="<?= old('email', $user->email) ?>"
           type="text"
           required="required"
           class="validate">
    <label for="email"><?= lang('email') ?></label>
  </div>
</div>
<?php
if (!$options['disabled']): ?>
  <div class="row">
    <div class="input-field col s6">
      <input id="password"
          <?= ($options['disabled']) ? 'disabled' : '' ?>
             name="password"
             type="password"
             class="validate"
          <?= (!$edit) ? 'required' : '' ?>
      >
      <label for="password"><?= lang('password') ?></label>
    </div>
    <div class="input-field col s6">
      <input id="password-confirm"
          <?= ($options['disabled']) ? 'disabled' : '' ?>
             name="password_confirm"
             type="password"
             class="validate"
          <?= (!$edit) ? 'required' : '' ?>
      >
      <label for="password-confirm"><?= lang('confirm password') ?></label>
    </div>
  </div>
<?php
endif; ?>

<div class="row">
  <div class="input-field col s6">
    <input id="firstname"
           name="firstname"
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           value="<?= old('firstname', $user->firstname) ?>"
           type="text"
           class="validate">
    <label for="firstname"><?= lang('firstname') ?></label>
  </div>
  <div class="input-field col s6">
    <input id="lastname"
           name="lastname"
        <?= ($options['disabled']) ? 'disabled' : '' ?>
           value="<?= old('lastname', $user->lastname) ?>"
           type="text">
    <label for="lastname"><?= lang('lastname') ?></label>
  </div>
</div>
<div class="row">
  <div class="input-field col s6">
      <?= form_dropdown(
          'role',
          [
              'guest' => lang('guest'),
              'author' => lang('author'),
              'admin' => lang('admin')
          ],
          $user->role,
          ($options['disabled']) ? 'disabled' : ''
      ) ?>
    <label for="role"><?= lang('role') ?></label>
  </div>
</div>

<div class="row">
  <div class="col s12">
    <button type="button" onclick="history.back()"
            class="btn waves-effect waves-light"><?= lang('General.back') ?>
      <i class="material-icons left">arrow_back</i></button>
      <?php
      if (!$options['disabled']) : ?>
        <button type="submit" class="btn waves-effect waves-light"><?= lang('General.submit') ?>
          <i class="material-icons right">send</i></button>
      <?php
      endif; ?>
  </div>
</div>