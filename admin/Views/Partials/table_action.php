<?php
/** @var string $controller the controller name */
/** @var string|int $data_id the data id */
/** @var */
$user = service('auth')->getUser();
?>

<list-actions :data-id="<?= $data_id ?>"
              controller="<?= $controller ?>"
              :is-system="<?= empty($is_system) ? 'false' : 'true' ?>"
              :user="<?= esc(json_encode($user)) ?>"/>
