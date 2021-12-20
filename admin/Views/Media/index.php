<?php
/**
 * @var string $theme
 * @var string $currentPath
 */

$this->extend("AdminThemes\\$theme\\layouts\\default"); ?>

<?php
$this->section('main') ?>

<?= $this->include('Admin\Partials\form_errors'); ?>

<div class="row">
  <div class="col s12">
    <h5><?= lang('Media.media_content') ?></h5>
    <p>
        <?= view_cell('\Admin\Views\Cells\MediaBreadcrumb::render', ['path' => $currentPath]) ?>
    </p>
  </div>
</div>

<div class="row">
  <div class="col xl6 l12 s12">
    <div class="card">
      <div class="card-content">
          <?= lang('Media.upload_file') ?>
          <span class="helper-text">
              <i data-position="right"
                 data-tooltip="<?= lang('Media.upload_warning') ?>"
                 class="material-icons tooltipped">help_outline</i>
          </span>
        <form method="post" enctype="multipart/form-data" action="/admin/media/upload">
            <?= csrf_field() ?>
          <div class="flex flex-center">
            <div class="col s12 m10">
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
            <div class="col s12 m2 right-align">
              <button type="submit" class="btn waves-effect waves-light">
                  <?= lang('General.upload') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="col xl6 l12 s12">
    <div class="card">
      <div class="card-content">
        <p><?= lang('Media.create_folder') ?></p>
        <form method="post" action="/admin/media/create-folder">
            <?= csrf_field() ?>
          <div class="flex flex-center">
            <div class="col s12 m10">
              <div class="input-field">
                <input id="dir_name"
                       type="text"
                       required="required"
                       name="dir_name"/>
                <label for="dir_name"><?= lang('Media.folder_name') ?></label>
              </div>
            </div>
            <div class="col s12 m2 right-align">
              <button type="submit" class="btn waves-effect waves-light">
                  <?= lang('General.create') ?>
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
if (empty($dirs) && empty($files)): ?>
  <div class="row">
    <div class="col s12 center-align">
      <h4><?= lang('Media.empty_dir') ?></h4>
    </div>
  </div>
<?php
endif; ?>

<form ref="file_form" method="post" :action="fileFormAction">
    <?= csrf_field() ?>
  <input type="hidden" ref="remove_file" name="remove_file" value=""/>
  <input type="hidden" ref="remove_dir" name="remove_dir" value=""/>
  <div class="row">
    <div class="col s12">
        <?php
        if (count($currentPath) > 0) : ?>
          <div class="card folder-card green darken-2">
            <div class="card-content">
              <a class="white-text" href="/admin/media/index?dir=up">
                <p><i class="large material-icons">arrow_upward</i></p>
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
            <div class="card-content center-align">
              <a class="flex flex-center flex-columm"
                 href="/admin/media/index?dir=<?= urlencode($dir) ?>">
                <p class="white-text"><i class="medium material-icons">folder</i></p>
                <p class="folder-name"><?= $dir ?></p>
              </a>
              <button type="button"
                      @click="onDeleteDirectory('<?= $dir ?>')"
                      title="<?= lang('General.delete') ?>"
                      class="btn-small waves-effect waves-light red darken-2">
                <i class="material-icons">delete</i>
              </button>
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
                <p><span><?= lang('Media.file_name') ?></span>: <span><?= $file['name'] ?></span></p>
                <p><span><?= lang('Media.file_size') ?></span>: <span>~ <?= round($file['size'] / 1000) ?> kB</span>
                </p>
              </div>
              <div class="card-action">
                <button type="button"
                        @click="onDeleteMedia('<?= $file['name'] ?>')"
                        class="btn-small waves-light waves-effect red darken-2"><?= lang('General.delete') ?>
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
