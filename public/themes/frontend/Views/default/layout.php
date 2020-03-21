<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $description ?>">
    <meta name="author" content="<?= $author ?>">
    <title><?= $title ?></title>

    <?= link_tag('css/bulma.min.css') ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body>
<h1>Welcome To My Page</h1>
<main role="main" class="container">
    <?= $this->renderSection('main') ?>
</main><!-- /.container -->

<?= script_tag('js/axios.min.js') ?>
<?= $this->renderSection('scripts') ?>
</body>
</html>