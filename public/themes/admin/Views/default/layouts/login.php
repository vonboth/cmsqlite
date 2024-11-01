<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>

  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <?= link_tag('themes/admin/Views/default/css/login.css') ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body class="valign-wrapper center-align">
<main role="main" class="container">
  <div class="row center-align">
    <div class="col s12 m6 offset-m3">
        <?= render_errors() ?>
    </div>
  </div>
  <div class="row center-align">
    <div class="col s12 m6 offset-m3">
      <div class="card card-login">
        <div class="card-content">
          <span class="card-title indigo white-text z-depth-4">Login</span>
          <form method="post" action="/admin/authenticate/login">
              <?= csrf_field() ?>
            <div class="input-field">
              <input id="username" required
                     name="username"
                     type="text"
                     class="validate">
              <label for="username" class=""><?= lang('admin.user.username') ?></label>
            </div>
            <div class="input-field">
              <input id="password" required
                     name="password"
                     type="password"
                     class="validate">
              <label for="password"><?= lang('admin.user.password') ?></label>
            </div>
            <br>
            <div>
              <button class="btn right indigo waves-effect waves-light white-text"
                      type="submit"><?= lang('admin.user.login') ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>
<?= $this->include('Admin\Partials\flash') ?>
</body>
</html>
