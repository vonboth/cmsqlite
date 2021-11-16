<ul class="action-list" id="table_action">
    <li>
        <a href="/admin/<?= $controller ?>/view/<?= $data_id ?> ">
            <i class="material-icons">remove_red_eye</i>
        </a>
    </li>
    <li>
        <a href="/admin/<?= $controller ?>/edit/<?= $data_id ?>">
            <i class="material-icons">create</i>
        </a>
    </li>
    <?php
    if (!isset($options['is_system'])): ?>
        <li>
            <a href="javascript:void(0)" @click="onDeleteItem('<?= $controller ?>', <?= $data_id ?>)">
                <i class="material-icons">delete</i>
            </a>
        </li>
    <?php
    elseif (!$options['is_system']): ?>
        <li>
            <a href="javascript:void(0)" @click="onDeleteItem('<?= $controller ?>', <?= $data_id ?>)">
                <i class="material-icons">delete</i>
            </a>
        </li>
    <?php
    endif; ?>
</ul>