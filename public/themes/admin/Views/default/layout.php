<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Admin Page">
    <meta name="author" content="Christoph von Both | creatingcode.de">
    <title>Title</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?= link_tag('themes/admin/Views/default/css/layout.css') ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body class="has-fixed-sidenav">
<header>
    <div class="navbar-fixed">
        <nav class="navbar white">
            <div class="nav-wrapper">
                <a href="#!" class="brand-logo grey-text text-darken-4">CMSQlite Administration</a>
                <a href="#!"
                   data-target="sidenav-left" class="sidenav-trigger right">
                    <i class="material-icons black-text">menu</i>
                </a>
            </div>
        </nav>
    </div>
    <ul class="sidenav sidenav-fixed">
        <li>Startseite</li>
        <li><a href="/admin/articles"><?= lang('Menu.articles') ?></a></li>
        <li><a href="/admin/categories"><?= lang('Menu.categories') ?></a></li>
        <li><a href="/admin/users"><?= lang('Menu.users') ?></a></li>
    </ul>
</header>
<main>
    <div class="container" id="main">
        <?= $this->renderSection('main') ?>
    </div>
</main>
<footer class="page-footer" id="footer">
    <div class="container">
        <span>Hallo Welt</span>
    </div>
</footer>

<?= script_tag('themes/admin/Views/default/js/vendor.bundle.js') ?>
<?= script_tag('themes/admin/Views/default/js/admin.bundle.js') ?>
<?= $this->renderSection('scripts') ?>
<?= $this->renderSection('js') ?>
<?= $this->include('Admin\Partials\flash') ?>
</body>
</html>