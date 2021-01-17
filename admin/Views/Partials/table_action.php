<ul class="action-list" id="table_action">
    <li>
        <a href="/admin/<?= $options['controller'] ?>/view/<?= $options['id'] ?> ">
            <i class="material-icons">remove_red_eye</i>
        </a>
    </li>
    <li>
        <a href="/admin/<?= $options['controller'] ?>/edit/<?= $options['id'] ?>">
            <i class="material-icons">create</i>
        </a>
    </li>
    <?php
    if (!isset($options['is_system'])): ?>
        <li>
            <a href="javascript:void(0)" @click="onDeleteItem('<?= $options['controller'] ?>', <?= $options['id'] ?>)">
                <i class="material-icons">delete</i>
            </a>
        </li>
    <?php
    elseif (!$options['is_system']): ?>
        <li>
            <a href="javascript:void(0)" @click="onDeleteItem('<?= $options['controller'] ?>', <?= $options['id'] ?>)">
                <i class="material-icons">delete</i>
            </a>
        </li>
    <?php
    endif; ?>
</ul>