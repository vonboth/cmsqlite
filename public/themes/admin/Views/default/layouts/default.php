<?php
/**
 * Admin section layout file
 */

/** @var bool $tour */
/** @var string $controller */
/** @var string $section */
/** @var string $version */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Page">
    <meta name="author" content="Christoph von Both | creatingcode.de">
    <?= csrf_meta() ?>
    <title><?= $title ?? 'CMSQLite' ?></title>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="/themes/admin/Views/default/css/materialize.min.css">
    <script src="/themes/admin/Views/default/js/materialize.min.js"></script>

    <!-- Compiled and minified CSS -->
    <!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@2.1.1/dist/css/materialize.min.css"-->
    <!-- Compiled and minified JavaScript -->
    <!--script-- src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@2.1.1/dist/js/materialize.min.js"></script-->


    <?php
    if ($tour): ?>
        <link href="https://unpkg.com/intro.js/minified/introjs.min.css" rel="stylesheet">
        <script src="https://unpkg.com/intro.js/minified/intro.min.js" crossorigin="anonymous"></script>
    <?php
    endif; ?>

    <script type="text/javascript">
      const translations = <?= json_encode(lang('Javascript.all')) ?>;
    </script>

    <?= link_tag('themes/admin/Views/default/css/layout.css') ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
    <?= $this->renderSection('js_vars') ?>
    <?= vite('admin/resources/main.js') ?>
</head>

<body class="has-fixed-sidenav">
<header>
    <!-- top nav -->
    <div class="navbar-fixed">
        <nav class="navbar blue">
            <div class="nav-wrapper">
                <a href="/admin/<?= $controller ?>" class="brand-logo"><?= $section ?></a>
                <ul class="right" id="profile-menu">
                    <li>
                      <a href="/admin/profile" title="<?= lang('User.my_profile') ?>">
                        <i class="material-icons">person</i>
                      </a>
                    </li>
                    <li>
                      <a href="/admin/authenticate/logout" title="<?= lang('User.logout') ?>">
                        <i class="material-icons">power_settings_new</i>
                      </a>
                    </li>
                </ul>
                <a href="#" data-target="sidenav-left" class="sidenav-trigger left">
                    <i class="material-icons">menu</i>
                </a>
            </div>
        </nav>
    </div>

    <!-- sidenav -->
    <ul id="sidenav-left" class="sidenav sidenav-fixed">
        <li>
            <a href="/admin" class="logo-container"><?= lang('Menu.startpage') ?>
                <i class="material-icons left">home</i>
            </a>
        </li>
        <li class="no-padding">
            <?= $this->include('Admin\Partials\admin_menu') ?>
        </li>
    </ul>
</header>

<main>
    <div class="container" id="main">
        <div class="row equal-height-grid">
            <?= $this->renderSection('main') ?>
        </div>
    </div>
</main>

<footer class="page-footer" id="footer">
    <div class="container">
        <span>CMSQLite V <span><?= $version ?></span></span>
    </div>
</footer>

<?= $this->renderSection('scripts') ?>
<?= $this->renderSection('js') ?>
<?= $this->include('Admin\Partials\flash') ?>
</body>
</html>
