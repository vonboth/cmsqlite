<div class="row">
    <div class="input-field col s6">
        <input id="username"
               name="username"
               value="<?= $user->username ?>"
               type="text"
               class="validate"
               required="required">
        <label for="username"><?= lang('username') ?></label>
    </div>
    <div class="input-field col s6">
        <input id="email"
               name="email"
               value="<?= $user->email ?>"
               type="text"
               required="required"
               class="validate">
        <label for="email"><?= lang('email') ?></label>
    </div>
</div>
<?php if (!$disabled): ?>
    <div class="row">
        <div class="input-field col s6">
            <input id="password"
                   name="password"
                   type="password"
                   value="<?= (!$edit) ? $user->password : '' ?>"
                   class="validate"
                <?= (!$edit) ? 'required' : '' ?>
            >
            <label for="password"><?= lang('password') ?></label>
        </div>
        <div class="input-field col s6">
            <input id="password-confirm"
                   name="password_confirm"
                   type="password"
                   class="validate"
                <?= (!$edit) ? 'required' : '' ?>
            >
            <label for="password-confirm"><?= lang('confirm password') ?></label>
        </div>
    </div>
<?php endif; ?>

<div class="row">
    <div class="input-field col s6">
        <input id="firstname"
               name="firstname"
               value="<?= $user->firstname ?>"
               type="text"
               class="validate">
        <label for="firstname"><?= lang('firstname') ?></label>
    </div>
    <div class="input-field col s6">
        <input id="lastname"
               name="lastname"
               value="<?= $user->lastname ?>"
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
            ($disabled) ? 'disabled' : ''
        ) ?>
        <label for="role"><?= lang('role') ?></label>
    </div>
</div>
