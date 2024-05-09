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

    <script src="https://unpkg.com/vue@3/dist/vue.global.prod.js"></script>
</head>
<body>

<main id="main">
    <div class="container">
        <div class="row equal-height-grid">
            <h2><?= lang('Install.installation_routine') ?></h2>
            <?= $this->renderSection('main') ?>
        </div>
    </div>
</main>

<script src="//cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<?= $this->renderSection('js') ?>
<?= $this->include('Admin\Partials\flash', null, false) ?>
</body>
</html>

