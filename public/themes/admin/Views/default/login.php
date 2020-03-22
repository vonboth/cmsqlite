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
            <div class="card card-login">
                <div class="card-content">
                    <span class="card-title indigo white-text z-depth-4">Login</span>
                    <form>
                        <div class="input-field">
                            <input id="username" name="username" type="text" class="validate">
                            <label for="username" class="">Username</label>
                        </div>
                        <div class="input-field">
                            <input id="password" name="password" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                        <br>
                        <div>
                            <button class="btn right indigo waves-effect waves-light white-text"
                                    type="submit"><?= lang('general.login') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>