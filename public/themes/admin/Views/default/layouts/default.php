<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Page">
    <meta name="author" content="Christoph von Both | creatingcode.de">
    <?= csrf_meta() ?>
    <title><?= isset($title) ? $title : 'CMSQLite' ?></title>

    <link href="//fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="//fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <script type="text/javascript">
      const translations = <?= json_encode(lang('Javascript.all')) ?>;
    </script>

    <?= link_tag('themes/admin/Views/default/css/layout.css') ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>

<body class="has-fixed-sidenav">
<header>
    <!-- top nav -->
    <div class="navbar-fixed">
        <nav class="navbar blue">
            <div class="nav-wrapper">
                <a href="/admin/<?= $controller ?>" class="brand-logo"><?= $section ?></a>
                <ul class="right">
                    <li>
                        <a href="#!" class="dropdown-trigger" data-target="profile_menu">
                            <i class="material-icons">person</i>
                        </a>
                        <ul id="profile_menu" class="dropdown-content">
                            <li><a href="/admin/profile"><?= lang('User.my_profile') ?></a></li>
                            <li><a href="/admin/authenticate/logout"><?= lang('User.logout') ?></a></li>
                        </ul>
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

<?= $this->renderSection('js_vars') ?>
<?= $this->renderSection('scripts') ?>
<?= script_tag('themes/admin/Views/default/js/vendor.bundle.js') ?>
<?= script_tag('themes/admin/Views/default/js/admin.bundle.js') ?>
<?= $this->renderSection('js') ?>
<?= $this->include('Admin\Partials\flash') ?>
</body>
</html>