<?php
/**
 * Renders a slider
 */

/** @var array $images */
/** @var array $image */
foreach ($images as $image): ?>
  <div>
    <img src="<?= $image['src'] ?>" alt="<?= $image['name'] ?>" title="<?= $image['name'] ?>"/>
  </div>
<?php
endforeach; ?>
