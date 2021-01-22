<?php
/** @var \CodeIgniter\Validation\Validation $validator */

/** @var string $server */
/** @var string $scheme HTTP || HTTPS */
/** @var array $permissions */
/** @var bool $db_writable */

$errors = $validator->getErrors();
?>

<?= $this->extend('Install\layouts\default'); ?>

<?= $this->section('main') ?>
    <div>

        <?php
        if ($errors): ?>
            <?php
            foreach ($errors as $error) : ?>
                <div class="card-panel red lighten-2" role="alert">
                    <?= $error ?>
                </div>
            <?php
            endforeach; ?>
        <?php
        endif; ?>

        <form action="//<?= $server ?>/install" method="post">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs">
                        <li class="tab col s4">
                            <a class="active" href="#step1"><?= lang('Install.step') ?> 1</a>
                        </li>
                        <li class="tab col s4">
                            <a href="#step2"><?= lang('Install.step') ?> 2</a>
                        </li>
                        <li class="tab col s4">
                            <a href="#step3"><?= lang('Install.step') ?> 3</a>
                        </li>
                    </ul>
                </div>

                <!-- STEP 1 -->
                <div id="step1" class="col s12">
                    <h3><?= lang('Install.directory_check') ?></h3>
                    <div class="card-panel <?= $db_writable ? 'green' : 'red' ?> lighten-2">
                        <i class="material-icons left"><?= $db_writable ? 'check' : 'close' ?></i>
                        <?= ($db_writable)
                            ? lang('Install.database_writable')
                            : lang('Install.database_not_writable') ?>
                    </div>

                    <?php
                    foreach ($permissions as $name => $permission): ?>
                        <div class="card-panel <?= ($permission['writable']) ? 'green' : 'red' ?> lighten-2">
                            <i class="material-icons left"><?= ($permission['writable']) ? 'check' : 'clear' ?></i>
                            <?= ($permission['writable'])
                                ? lang('Install.directory_writable', [$name, $permission['permission']]) :
                                lang('Install.directory_not_writable', [$name, $permission['permission']]) ?>
                        </div>
                    <?php
                    endforeach; ?>

                    <div class="row"></div>
                    <div class="card-panel blue lighten-2">
                        <p>
                            <span class="material-icons left">info</span>&nbsp;
                            <?= lang('Install.permission_explanation') ?>
                        </p>
                    </div>

                    <!-- NAVIGATION BUTTON -->
                    <div class="row">
                        <div class="col right">
                            <a class="btn" @click="moveStep('step2')">
                                <i class="material-icons right">arrow_forward</i>
                                <?= lang('Install.next') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- STEP 2 -->
                <div id="step2" class="col s12">

                    <div>
                        <h3><?= lang('Install.website_settings') ?></h3>
                        <div class="row">
                            <div class="col s12 m8 offset-m1 xl7 offset-xl1">
                                <div class="row">
                                    <div class="input-field">
                                        <input type="text"
                                               placeholder="<?= lang('Install.base_url_placeholder') ?>"
                                               name="base_url"
                                               required="required"
                                               class="validate"
                                               value="<?= esc(old('base_url', "$scheme://$server")) ?>"
                                               id="base_url"/>
                                        <label for="base_url"><?= lang('Install.base_url') ?></label>
                                        <span class="helper-text"><?= lang('Install.base_url_help') ?></span>

                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input type="text"
                                               placeholder="<?= lang('Install.language') ?>"
                                               name="language"
                                               required="required"
                                               class="validate"
                                               value="<?= esc(old('base_url', 'de')) ?>"
                                               id="language"/>
                                        <label for="language"><?= lang('Install.language') ?></label>
                                        <span class="helper-text"><?= lang('Install.language_help') ?></span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input type="text"
                                               placeholder="<?= lang('Install.timezone') ?>"
                                               name="timezone"
                                               required="required"
                                               class="validate"
                                               value="<?= esc(old('timezone', 'Europe/Berlin')) ?>"
                                               id="timezone"/>
                                        <label for="timezone"><?= lang('Install.timezone') ?></label>
                                        <span class="helper-text"><?= lang('Install.timezone_help') ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NAVIGATION BUTTON -->
                    <div class="row">
                        <div class="col left">
                            <a class="btn" @click="moveStep('step1')">
                                <i class="material-icons left">arrow_back</i>
                                <?= lang('Install.back') ?>
                            </a>
                        </div>
                        <div class="col right">
                            <a class="btn" @click="moveStep('step3')">
                                <i class="material-icons right">arrow_forward</i>
                                <?= lang('Install.next') ?>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- STEP 3 -->
                <div id="step3" class="col s12">

                    <div>
                        <h3><?= lang('Install.set_admin_user') ?></h3>
                        <div class="row">
                            <div class="col s12 m8 offset-m1 xl7 offset-xl1">
                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.username') ?>"
                                               name="username"
                                               required="required"
                                               id="username"
                                               type="text"
                                               value="<?= esc(old('username')) ?>"
                                               class="validate">
                                        <label for="username"><?= lang('Install.username') ?></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.password') ?>"
                                               name="password"
                                               required="required"
                                               id="password"
                                               type="password"
                                               class="validate">
                                        <a href="javascript:void(0)" @click="onShowPassword">
                                            <i class="material-icons prefix grey-text" id="password-icon">visibility</i>
                                        </a>
                                        <label for="password"><?= lang('Install.password') ?></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.password_confirm') ?>"
                                               name="password_confirm"
                                               required="required"
                                               id="password_confirm"
                                               type="password"
                                               class="validate">
                                        <label for="password_confirm"><?= lang('Install.password_confirm') ?></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.email') ?>"
                                               name="email"
                                               required="required"
                                               id="email"
                                               type="email"
                                               value="<?= esc(old('email')) ?>"
                                               class="validate">
                                        <label for="email"><?= lang('Install.email') ?></label>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.firstname') ?>"
                                               name="firstname"
                                               id="firstname"
                                               required="required"
                                               type="text"
                                               value="<?= esc(old('firstname')) ?>"
                                               class="validate">
                                        <label for="firstname"><?= lang('Install.firstname') ?></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field">
                                        <input placeholder="<?= lang('Install.lastname') ?>"
                                               name="lastname"
                                               id="lastname"
                                               type="text"
                                               value="<?= esc(old('lastname')) ?>"
                                               class="validate">
                                        <label for="lastname"><?= lang('Install.lastname') ?></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- NAVIGATION BUTTON -->
                    <div class="row">
                        <div class="col left">
                            <a class="btn" @click="moveStep('step2')">
                                <i class="material-icons left">arrow_back</i>
                                <?= lang('Install.back') ?>
                            </a>
                        </div>
                        <div class="col right">
                            <button class="btn" type="submit">
                                <?= lang('Install.done') ?>!
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
    <script type="text/javascript">

      const VUE = new Vue({
        el: '#main',
        data: function() {
          return {
            tabs: null
          };
        },
        mounted: function() {
          this.tabs = M.Tabs.init(document.querySelector('.tabs'));
        },
        methods: {
          moveStep: function(step) {
            this.tabs.select(step);
          },
          onShowPassword: function() {
            const EL = document.getElementById('password');
            const ICON = document.getElementById('password-icon');
            let type = EL.getAttribute('type');
            if (type === 'password') {
              EL.setAttribute('type', 'text');
              ICON.innerText = 'visibility_off';
            } else {
              EL.setAttribute('type', 'password');
              ICON.innerText = 'visibility';
            }
          }
        }
      });
    </script>
<?= $this->endSection() ?>