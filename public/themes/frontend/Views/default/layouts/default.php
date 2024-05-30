<?php
/** @var \Admin\Models\Entities\Article $article */
/** @var string $locale the curren locale */
/** @var string $theme the theme configured in admin-section */
?>
<!DOCTYPE html>
<html lang="<?= $locale ?>">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <meta name="description" content="<?= $article->description ?>">
  <meta name="author" content="<?= ($article->user) ? $article->user->fullname : '' ?>">
  <title><?= $article->title ?></title>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <?= link_tag("themes/frontend/Views/$theme/css/default.css"); ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body>

<nav class="indigo darken-1" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="/" class="brand-logo">CMSQLite</a>
    <!-- The menu -->
      <?= view_cell(
        'App\Views\Cells\Menu::render',
        [
          'id' => 1,
          'ulClass' => 'ul_parent right hide-on-med-and-down',
          'template' => 'menu'
        ]
      ) ?>

    <!-- The mobile menu -->
      <?= view_cell(
          'App\Views\Cells\Menu::render',
          ['id' => 2, 'ulClass' => 'sidenav ul_parent', 'ulId' => 'nav-mobile']
      ) ?>

    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>
</nav>

<main role="main" class="section no-pad-bot" id="index-banner">
  <section class="container">
      <?= $this->renderSection('main') ?>
  </section>
</main><!-- /.container -->


<footer class="page-footer orange">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">CMSQLite</h5>
        <p class="grey-text text-lighten-4">CMSQLite - created by CreatingCode.de</p>
        <p class="grey-text text-lighten-4">Visit our webpage or GitHub repo.</p>
      </div>
      <div class="col l3 s12">
        <h5 class="white-text">Links</h5>
        <ul>
          <li style="margin-bottom: .5rem">
              <a class="white-text" href="https://github.com/vonboth/cmsqlite" target="_blank">
                  CMSQLite@GitHub<i class="material-icons left">launch</i>
              </a>
          </li>
          <li>
              <a class="white-text" href="https://www.creatingcode.de" target="_blank">
                  CreatingCode.de<i class="material-icons left">star</i>
              </a>
          </li>
        </ul>
      </div>
      <div class="col l3 s12"></div>
    </div>
  </div>

  <div class="footer-copyright">
    <div class="container">
      Made by <a class="orange-text text-lighten-3" href="http://materializecss.com">Materialize</a>
    </div>
  </div>
</footer>

<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<?= script_tag("/themes/frontend/Views/$theme/js/init.js") ?>

<?= $this->renderSection('jsvars') ?>
<?= $this->renderSection('scripts') ?>
<?= $this->renderSection('js') ?>
</body>
</html>
