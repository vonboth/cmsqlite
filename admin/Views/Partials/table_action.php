<?php
/** @var string $controller the controller name */
/** @var string|int $data_id the data id */
/** @var */
$user = service('auth')->getUser();
?>
<ul class="action-list" id="table_action">
  <?php if ($user['role'] !== 'admin'): ?>
    <li>
      <a href="/admin/<?= $controller ?>/view/<?= $data_id ?> ">
        <i class="material-icons">remove_red_eye</i>
      </a>
    </li>
  <?php endif; ?>
  <li>
    <a href="/admin/<?= $controller ?>/edit/<?= $data_id ?>">
      <i class="material-icons">create</i>
    </a>
  </li>
  <?php
  if (!isset($is_system)): ?>
    <li>
      <a href="javascript:void(0)" @click="onDeleteItem('<?= $controller ?>', <?= $data_id ?>)">
        <i class="material-icons">delete</i>
      </a>
    </li>
  <?php
  elseif (!$is_system): ?>
    <li>
      <a href="javascript:void(0)" @click="onDeleteItem('<?= $controller ?>', <?= $data_id ?>)">
        <i class="material-icons">delete</i>
      </a>
    </li>
  <?php
  endif; ?>
</ul>
