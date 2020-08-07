<?php
if (!empty($errors)) : ?>
    <div class="errors red card-panel lighten-2" role="alert">
        <ul>
            <?php
            foreach ($errors as $error) : ?>
                <li><?= esc($error) ?></li>
            <?php
            endforeach ?>
        </ul>
    </div>
<?php
endif; ?>