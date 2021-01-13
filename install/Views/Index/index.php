<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="CMSQLite Installation Page">
    <meta name="author" content="Christoph von Both | creatingcode.de">

    <title>CMSQLite Installation</title>

    <link href="//fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

    <script src="/js/vue.min.js"></script>
</head>
<body>

<main id="main">
    <div class="container">
        <h2><?= lang('Install.installation_routine') ?></h2>
        <?= form_open('Install.install') ?>
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
                    <div class="card-panel <?= ($permission === '777' || $permission == '775') ? 'green' : 'red' ?> lighten-2">
                        <i class="material-icons left"><?= ($permission === '777' || $permission === '775') ? 'check' : 'clear' ?></i>
                        <?= ($permission === '777' || $permission === '775')
                            ? lang('Install.directory_writable', [$name, $permission]) :
                            lang('Install.directory_not_writable', [$name, $permission]) ?>
                    </div>
                <?php
                endforeach; ?>

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
                                           name="base_uri"
                                           required="required"
                                           class="validate"
                                           value="<?= esc(old('base_url')) ?>"
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

        <?= form_close() ?>
    </div>
</main>

<?= $this->include('Admin\Partials\flash') ?>

<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
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
</body>
</html>
