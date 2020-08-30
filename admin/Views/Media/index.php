<?php

$this->extend('AdminThemes\default\default'); ?>

<?php
$this->section('main') ?>
<div class="row">
  <div class="col s12">
    <div class="card">
      <div class="card-content">
        <p><?= lang('General.upload_file') ?></p>
        <form method="post" enctype="multipart/form-data" action="/admin/media/upload">
            <?= csrf_field() ?>
          <div class="row flex flex-center">
            <div class="col s10">
              <div class="file-field input-field">
                <div class="btn">
                  <span>File</span>
                  <input type="file" required="required" name="media_file">
                </div>
                <div class="file-path-wrapper">
                  <input class="file-path validate" type="text">
                </div>
              </div>
            </div>
            <div class="col s2 right-align">
              <button type="submit" class="btn waves-effect waves-light">
                  <?= lang('General.submit') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="row">
  <div class="col s12">
    <h5><?= lang('General.media_content') ?></h5>
    <p>
        <?= view_cell('\Admin\Views\Cells\MediaBreadcrumb::render', ['path' => $currentPath]) ?>
    </p>
  </div>
</div>

<form ref="file_form" method="post" action="/admin/media/remove">
  <?= csrf_field() ?>
  <input type="hidden" ref="remove_file" name="remove_file" value="" />
  <div class="row">
    <div class="col s12">
        <?php
        if (count($currentPath) > 0) : ?>
          <div class="card folder-card green darken-2">
            <div class="card-content">
              <a class="white-text" href="/admin/media/index?dir=up">
                <p><i class="large material-icons">arrow_upward</i></p>
                <p>..</p>
              </a>
            </div>
          </div>
        <?php
        endif; ?>

        <?php
        /** @var array $dirs */

        /** @var string $dir */
        foreach ($dirs as $dir): ?>
          <div class="card folder-card yellow darken-2">
            <div class="card-content">
              <a class="white-text" href="/admin/media/index?dir=<?= urlencode($dir) ?>">
                <p><i class="large material-icons">folder</i></p>
                <p><?= $dir ?></p>
              </a>
            </div>
          </div>
        <?php
        endforeach; ?>

        <?php
        /** @var array $files */

        /** @var array $file */
        foreach ($files as $file): ?>
          <div class="card file-card horizontal">
            <div class="card-image">
                <?php
                switch ($file['ext']):
                    case 'jpg':
                    case 'jpeg':
                    case 'png': ?>
                      <img src="<?= $file['src'] ?>" alt="<?= $file['name'] ?>" title="<?= $file['name'] ?>"/>
                        <?php
                        break;
                    case 'pdf': ?>
                      <div class="flex flex-center h100"><i class="material-icons large">picture_as_pdf</i></div>
                        <?php
                        break;
                    default: ?>
                      <div class="flex flex-center h100"><i class="material-icons large">description</i></div>
                    <?php
                endswitch; ?>
            </div>
            <div class="card-stacked">
              <div class="card-content">
                <p><span><?= lang('General.file_name') ?></span>: <span><?= $file['name'] ?></span></p>
                <p><span><?= lang('General.file_size') ?></span>: <span>~ <?= round($file['size'] / 1000) ?> kB</span>
                </p>
              </div>
              <div class="card-action">
                <button type="button"
                        @click="onDeleteMedia('<?= $file['name'] ?>')"
                        class="btn waves-light waves-effect red darken-2"><?= lang('General.delete') ?>
                  <i class="material-icons right">delete_forever</i></button>
              </div>
            </div>
          </div>
        <?php
        endforeach; ?>
    </div>
  </div>
</form>
<?php
$this->endSection() ?>
