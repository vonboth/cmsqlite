<?php
/** @var \Admin\Models\Entities\Article $article */
/** @var string $locale the curren locale */
/** @var string $theme the theme configured in admin-section */
?>
<!DOCTYPE html>
<html lang="<?= $locale ?>" class="h-100">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <meta name="description" content="<?= $article->description ?>">
    <meta name="author" content="<?= ($article->user) ? $article->user->fullname : '' ?>">
    <title><?= $article->title ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <?= link_tag("themes/frontend/Views/$theme/css/landing.css"); ?>

    <?= $this->renderSection('css') ?>
    <?= $this->renderSection('headerScripts') ?>
</head>
<body class="d-flex h-100 text-center">
<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
    <header class="mb-auto">
        <div>
            <h3 class="float-md-start mb-0"><a href="/" class="nav-link">CMSQLite</a></h3>
            <nav class="nav nav-masthead justify-content-center float-md-end">
                <a class="nav-link fw-bold py-1 px-0 active" aria-current="page" href="/">Home</a>
            </nav>
        </div>
    </header>

    <main class="px-3 text-white">
        <?= $article->content ?>
    </main>

    <footer class="mt-auto text-white-50">
        <p></p>
    </footer>
</div>
</body>
