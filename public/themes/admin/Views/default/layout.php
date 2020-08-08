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
  <!-- top nav -->
  <div class="navbar-fixed">
    <nav class="navbar blue">
      <div class="nav-wrapper">
        <ul class="right">
          <li>
            <a href="#!" class="dropdown-trigger" data-target="profile_menu">
              <i class="material-icons">person</i>
            </a>
            <ul id="profile_menu" class="dropdown-content">
              <li><a href="#!">My Profile</a></li>
              <li><a href="#!">Logout</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </div>

  <!-- sidenav -->
  <ul ref="sidenav-left" class="sidenav sidenav-fixed">
    <li><a href="/admin" class="logo-container">CMSQlite Admin
        <i class="material-icons left">settings_applications</i>
      </a>
    </li>
    <li class="no-padding">
      <ul class="collapsible collapsible-accordion">
        <li><a href="/admin/articles"><?= lang('Menu.articles') ?></a></li>
        <li><a href="/admin/categories"><?= lang('Menu.categories') ?></a></li>
        <li><a href="/admin/users"><?= lang('Menu.users') ?></a></li>
      </ul>
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