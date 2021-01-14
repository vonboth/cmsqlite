<?php
/**
 * As you can see we do not need a special
 * main-section to display the startpage article
 *
 * Instead we use the Artcile-Cell to display all
 * articles in one page and use the menu-type "other"
 * to link to the different sections
 */

/** @var \Admin\Models\Entities\Article $article */

/** @var string $theme */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <meta name="description" content="<?= $article->description ?>">
  <meta name="author" content="<?= $article->user->fullname ?>">
  <title><?= $article->title ?></title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <?= link_tag(
        "/themes/frontend/Views/$theme/css/default.css",
        'stylesheet',
        'text/css',
        '',
        'screen,projection'
    ); ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body>
<nav class="white" role="navigation">
  <div class="nav-wrapper container">
    <a id="logo-container" href="#" class="brand-logo">CMSQLite Parallax Demo Page</a>

    <!-- The menu -->
      <?= view_cell('Views\Cells\Menu::render', ['id' => 1, 'ulClass' => 'ul_parent right hide-on-med-and-down']) ?>

    <!-- The mobile menu -->
      <?= view_cell(
          'Views\Cells\Menu::render',
          ['id' => 2, 'ulClass' => 'sidenav ul_parent', 'ulId' => 'nav-mobile']
      ) ?>

    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="material-icons">menu</i></a>
  </div>
</nav>

<div id="index-banner" class="parallax-container">
  <div class="section no-pad-bot">
    <div class="container">
        <?= view_cell('Views\Cells\Article::render', ['id' => 1]) ?>
    </div>
  </div>
  <div class="parallax">
      <?= img(
          "/themes/frontend/Views/$theme/img/background1.jpg",
          false,
          ['alt' => "Unsplashed background img 1"]
      ); ?>
  </div>
</div>

<div class="container">
  <div class="section">
      <?= view_cell('Views\Cells\Article::render', ['id' => 2, 'readon' => true]) ?>
  </div>
</div>

<div class="parallax-container valign-wrapper">
  <div class="section no-pad-bot">
    <div class="container">
      <div class="row center">
          <?= view_cell('Views\Cells\Article::render', ['id' => 3]) ?>
      </div>
    </div>
  </div>

  <div class="parallax">
      <?= img(
          "/themes/frontend/Views/$theme/img/background2.jpg",
          false,
          ['alt' => 'Background img 2']
      ) ?>
  </div>
</div>

<div class="container">
  <div class="section" id="news">
    <div class="row">
      <div class="col s12 center">
          <?
          /*= view_cell('Views\Cells\Article::render', ['id' => 4]) */ ?>
          <?= view_cell('Views\Cells\Category::render', ['id' => 2, 'readon' => true])
          ?>
      </div>
    </div>
  </div>
</div>

<div class="parallax-container valign-wrapper">
  <div class="section no-pad-bot">
    <div class="container">
      <div class="row center">
          <?= view_cell('Views\Cells\Article::render', ['id' => 5]) ?>
      </div>
    </div>
  </div>
  <div class="parallax">
      <?= img(
          "/themes/frontend/Views/$theme/img/background3.jpg",
          false,
          ['alt' => 'Unsplashed background img 3']
      ) ?>
  </div>
</div>

<footer class="page-footer teal" id="footer">
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
          <?= view_cell('Views\Cells\Article::render', ['alias' => 'footer']) ?>
      </div>
      <div class="col l3 s12">
        <h5 class="white-text">Settings</h5>
        <ul>
          <li><a class="white-text" href="#!">Link 1</a></li>
          <li><a class="white-text" href="#!">Link 2</a></li>
          <li><a class="white-text" href="#!">Link 3</a></li>
          <li><a class="white-text" href="#!">Link 4</a></li>
        </ul>
      </div>
      <div class="col l3 s12">
      </div>
    </div>
  </div>
  <div class="footer-copyright">
    <div class="container">
      Based on <a class="brown-text text-lighten-3" href="http://materializecss.com">Materialize</a> and CMSQlite
    </div>
  </div>
</footer>

<!--  Scripts-->
<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

<?= script_tag("themes/frontend/Views/$theme/js/init.js") ?>
<?= $this->renderSection('jsvars') ?>
<?= $this->renderSection('scripts') ?>
<?= $this->renderSection('js') ?>

</body>
</html>