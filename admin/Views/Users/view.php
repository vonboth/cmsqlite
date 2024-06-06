<?php
/**
 * @var string $theme
 */

$this->setData(['edit' => false]);
$this->setData(['formDisabled' => true]);
$this->extend("AdminThemes\\$theme\\layouts\\default"); ?>

<?php
$this->section('main') ?>
  <div class="card mh65vh">
    <div class="card-content">
      <div class="row">
        <h3><?= lang('Admin.view') ?></h3>
          <?= $this->include('Admin\Users\partials\user_form') ?>
      </div>
    </div>
  </div>
<?php
$this->endSection() ?>
