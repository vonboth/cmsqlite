<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Admin Page">
  <meta name="author" content="Christoph von Both | creatingcode.de">

  <link href="https://fonts.googleapis.com/css?family=Roboto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>

    <?= link_tag('themes/admin/Views/default/css/layout.css') ?>
</head>
<body>
<header>
  <div class="navbar-fixed">
    <nav class="navbar blue">
      <div class="nav-wrapper">
        <span class="brand-logo"><?= $section ?></span>
      </div>
    </nav>
  </div>
</header>

<?php
/** @var array $files */

?>
<main>
  <script type="text/javascript">
    function selectImage (path) {
      window.opener.CKEDITOR.tools.callFunction(1, path);
      window.close();
    }
  </script>
  <div class="row">
    <div class="col s12">
        <?php
        foreach ($files as $file): ?>
          <div class="card browse-image-card">
            <div class="card-image flex flex-center">
              <img src="<?= $file['path'] ?>" alt="<?= $file['name'] ?>" />
            </div>
            <div class="card-content center-align">
              <span><?= $file['name'] ?></span>
            </div>
            <div class="card-action">
              <button type="button"
                      class="btn waves-effect waves-light green darken-2"
                      onclick="selectImage('<?= $file['path'] ?>')">
                <?= lang('all.select') ?>
              </button>
            </div>
          </div>
        <?php
        endforeach; ?>
    </div>
  </div>
</main>
</body>
</html>
