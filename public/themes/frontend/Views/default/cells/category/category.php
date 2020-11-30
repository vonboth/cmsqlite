<?php
/** @var \Admin\Models\Entities\Category $category */
/** @var array $articles all articles */
?>
<div>
  <ul class="collection with-header">
    <li class="collection-header"><h4><?= $category->name ?></h4></li>
      <?php
      foreach ($articles as $article): ?>
      <li class="collection-item">
        <?= $article->content ?>
      </li>
      <?php
      endforeach; ?>
  </ul>
</div>