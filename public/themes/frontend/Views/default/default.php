<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?= $description ?>">
    <meta name="author" content="<?= 'SET FROM DB' ?>">
    <title><?= $title ?></title>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body>
<main role="main" class="container">
    <?= $this->renderSection('main') ?>
</main><!-- /.container -->

<?= $this->renderSection('jsvars') ?>
<?= $this->renderSection('scripts') ?>
<?= $this->renderSection('js') ?>
</body>
</html>