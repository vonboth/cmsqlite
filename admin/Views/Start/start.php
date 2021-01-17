<?php
/**
 * @var string $theme
 */

?>
<?= $this->extend("AdminThemes\\$theme\\layouts\\default") ?>

<?= $this->section('main') ?>
<div class="row">
  <div class="col s12">
    <div class="card welcome-box">
      <div class="card-content">
        <span class="card-title"><?= lang('Admin.welcome.welcome_to_cmsqlite') ?></span>
        <p></p>
        <div class="row">
          <div class="col s4">
            <p><?= lang('Admin.welcome.next_steps') ?></p>
            <ul>
              <li>
                <a href="/admin/articles/edit/1">
                  <i class="material-icons left">create</i> <?= lang('Admin.welcome.edit_startpage') ?>
                </a>
              </li>
              <li class="clearfix">
                <a href="/admin/articles/add">
                  <i class="material-icons left">add</i> <?= lang('Admin.welcome.create_page') ?>
                </a>
              </li>
              <li class="clearfix">
                <a href="/" target="_blank">
                  <i class="material-icons left">remove_red_eye</i> <?= lang('Admin.welcome.view_website') ?>
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
    <div class="card">
      <div class="card-content">
        <span class="card-title"><?= lang('Admin.last_loggedin_users') ?></span>
        <p></p>
        <ul class="collection">
            <?php
            foreach ($users as $user): ?>
              <li class="collection-item">
                <span><?= $user->fullname ?></span>
                <span class="right"><?= lang('{last, date} {last, time}', ['last' => $user->lastlogin]) ?></span>
              </li>
            <?php
            endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="col s12 m4">
    <div class="card">
      <div class="card-content">
        <span class="card-title"><?= lang('Admin.last_edited_articles') ?></span>
        <p></p>
        <ul class="collection">
            <?php
            foreach ($lastEditedArticles as $article): ?>
              <li class="collection-item">
                <span><?= $article->title ?></span>
                <span class="right"><?= lang(
                        '{updated, date} {updated, time}',
                        ['updated' => $article->updated]
                    ) ?></span>
              </li>
            <?php
            endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
  <div class="col s12 m4">
    <div class="card">
      <div class="card-content">
        <div>
          <span class="card-title">
              <span><?= lang('Admin.top_articles') ?></span>
              <a class="right"
                 href="javascript: void(0)"
                 @click="onResetHits"
                 title="<?= lang('Admin.reset_hits') ?>"><i class="material-icons">history</i></a>
          </span>
        </div>
        <p></p>
        <ul class="collection">
            <?php
            foreach ($topArticles as $article): ?>
              <li class="collection-item">
                <span><?= $article->title ?></span>
                <span class="ml1rem">(<?= $article->hits ?>)</span>
                <span class="right"><?= lang(
                        '{updated, date} {updated, time}',
                        ['updated' => $article->updated]
                    ) ?></span>
              </li>
            <?php
            endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
