<?php
/** @var bool $formDisabled */

/** @var \Admin\Models\Entities\User $user */
?>
<div class="hiddendiv">
    <input type="hidden" name="id" value="<?= $user->id ?>">
</div>
<div class=row>
    <div class="col s12 <?= (is_null($user->id) ? 'hide' : '') ?>">
        <span class="right">
            <?= lang('Tables.created') . ': ' . lang(
                '{created, date} {created, time}',
                ['created' => $user->created ?? new DateTime()]
            )
            . ' | ' . lang('Tables.updated') . ': ' . lang(
                '{updated, date} {updated, time}',
                ['updated' => $user->updated ?? new DateTime()]
            ) ?>
        </span>
    </div>
</div>

<div class="row">
    <div class="input-field col s12 m6">
        <input id="username"
               name="username"
               value="<?= old('username', $user->username) ?>"
            <?= ($formDisabled) ? 'disabled' : '' ?>
               type="text"
               class="validate"
               required="required">
        <label for="username"><?= lang('Tables.users.username') ?></label>
    </div>
    <div class="input-field col s12 m6">
        <input id="email"
               name="email"
            <?= ($formDisabled) ? 'disabled' : '' ?>
               value="<?= old('email', $user->email) ?>"
               type="text"
               required="required"
               class="validate">
        <label for="email"><?= lang('Tables.users.email') ?></label>
    </div>
</div>
<?php
if (!$formDisabled): ?>
    <div class="row">
        <div class="input-field col s12 m6">
            <input id="password"
                <?= ($formDisabled) ? 'disabled' : '' ?>
                   name="password"
                   type="password"
                   class="validate"
                <?= (!$edit) ? 'required' : '' ?>
            >
            <label for="password"><?= lang('Tables.users.password') ?></label>
        </div>
        <div class="input-field col s12 m6">
            <input id="password-confirm"
                <?= ($formDisabled) ? 'disabled' : '' ?>
                   name="password_confirm"
                   type="password"
                   class="validate"
                <?= (!$edit) ? 'required' : '' ?>
            >
            <label for="password-confirm"><?= lang('Tables.users.confirm_password') ?></label>
        </div>
    </div>
<?php
endif; ?>

<div class="row">
    <div class="input-field col s12 m6">
        <input id="firstname"
               name="firstname"
            <?= ($formDisabled) ? 'disabled' : '' ?>
               value="<?= old('firstname', $user->firstname) ?>"
               type="text"
               class="validate">
        <label for="firstname"><?= lang('Tables.users.firstname') ?></label>
    </div>
    <div class="input-field col s12 m6">
        <input id="lastname"
               name="lastname"
            <?= ($formDisabled) ? 'disabled' : '' ?>
               value="<?= old('lastname', $user->lastname) ?>"
               type="text">
        <label for="lastname"><?= lang('Tables.users.lastname') ?></label>
    </div>
</div>

<div class="row">
    <div class="input-field col s12 m6">
        <?= form_dropdown(
            'role',
            [
                'guest' => lang('Tables.users.roles.guest'),
                'author' => lang('Tables.users.roles.author'),
                'admin' => lang('Tables.users.roles.admin')
            ],
            $user->role,
            ($formDisabled) ? 'disabled' : ''
        ) ?>
        <label for="role"><?= lang('Tables.users.role') ?></label>
    </div>
</div>

<div class="row">
    <div class="col s12">
        <a href="/admin/<?= $controller ?>"
           class="btn waves-effect waves-light"><?= lang('General.back') ?>
            <i class="material-icons left">arrow_back</i></a>
        <?php
        if (!$formDisabled) : ?>
            <button type="submit" class="btn waves-effect waves-light ml1rem"><?= lang('General.submit') ?>
                <i class="material-icons right">send</i></button>
        <?php
        endif; ?>
    </div>
</div>
