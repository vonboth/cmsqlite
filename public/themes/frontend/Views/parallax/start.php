<?php
/**
 * The content for the startpage
 * This file extends the default layout file
 *
 */

/** @var \Admin\Models\Entities\Article $article */
/** @var string $theme */
?>

<?= $this->extend("Themes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
    <div id="index-banner" class="parallax-container">
        <div class="section no-pad-bot">
            <div class="container">
                <?= view_cell('Views\Cells\Article::render', ['id' => 2, 'readon' => true]) ?>
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
            <?= view_cell('Views\Cells\Article::render', ['id' => 1]) ?>
        </div>
    </div>

    <div class="parallax-container valign-wrapper" id="news">
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
        <div class="section">
            <div class="row">
                <div class="col s12 center">
                    <?= view_cell('Views\Cells\Category::render', ['id' => 2, 'readon' => true]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="parallax-container valign-wrapper" id="thanks">
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
<?= $this->endSection() ?>