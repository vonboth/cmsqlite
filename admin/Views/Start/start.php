<?php
/**
 * start page
 */

/**
 * @var string $theme
 * @var array $users
 * @var array $lastEditedArticles
 * @var array $topArticles
 * @var bool $tour
 */

?>
<?= $this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
<div class="row">
    <div class="col s12">
        <div class="card welcome-box">
            <div class="card-content" id="start__welcome">
                <span class="card-title"><?= lang('Admin.welcome.welcome_to_cmsqlite') ?></span>
                <p></p>
                <div class="row">
                    <div class="col s4">
                        <p><?= lang('Admin.welcome.next_steps') ?></p>
                        <ul>
                            <li>
                                <a href="/admin/articles/edit/1">
                                    <i class="material-icons left">create</i> <?= lang(
                                        'Admin.welcome.edit_startpage'
                                    ) ?>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="/admin/articles/add">
                                    <i class="material-icons left">add</i> <?= lang('Admin.welcome.create_page') ?>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="/" target="_blank">
                                    <i class="material-icons left">remove_red_eye</i> <?= lang(
                                        'Admin.welcome.view_website'
                                    ) ?>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col s4">
                        <p><?= lang('Admin.welcome.other_actions') ?></p>
                        <ul>
                            <li class="clearfix">
                                <a href="/admin/profile">
                                    <i class="material-icons left">person</i> <?= lang('Admin.welcome.edit_profile') ?>
                                </a>
                            </li>
                            <li>
                                <a href="/admin/menus">
                                    <i class="material-icons left">list</i> <?= lang('Admin.welcome.edit_menus') ?>
                                </a>
                            </li>
                            <li class="clearfix">
                                <a href="/admin/media">
                                    <i class="material-icons left">image</i> <?= lang('Admin.welcome.media_admin') ?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col s12 m4">
        <last-users :users="<?= esc(json_encode($users)) ?>"></last-users>
    </div>
    <div class="col s12 m4">
      <page-statistics :articles="<?= esc(json_encode($lastEditedArticles)) ?>"></page-statistics>
    </div>
    <div class="col s12 m4">
        <top-articles :articles="<?= esc(json_encode($topArticles)) ?>"></top-articles>
    </div>
</div>
<?= $this->endSection() ?>

<?php
if ($tour) : ?>
    <?= $this->section('scripts') ?>
    <?= script_tag("/themes/admin/Views/default/js/introJs.js") ?>
    <?= $this->endSection() ?>
<?php
endif; ?>
