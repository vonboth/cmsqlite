<?php


namespace App\Views\Cells;

use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;

/**
 * Class Category Cell
 * @package App\Views\Cells
 *
 * renders all articles for a given category
 *
 * Usefull if you want to show e.g. News in a certain
 * section of your page
 *
 * allowed options:
 * - id: category id
 * - render: true | false returns the articles bypassing the rendering
 * - readon: true | false strips all articles at readon. true means remove
 */
class Category extends AppCell
{
  /**
   * render categories. see above for basic usage
   * @param array $options
   * @return string
   */
  public function render(array $options = []): string
  {
    $default = [
      'readon' => false
    ];
    $options = $options + $default;
    $Articles = new ArticlesModel();
    $Categories = new CategoriesModel();

    $category = $Categories->find($options['id']);
    $articles = $Articles
      ->where('category_id', $options['id'])
      ->where('published', true)
      ->get()
      ->getResult();

    if ($articles) {
      // remove the readon if necessary
      foreach ($articles as $article) {
        $article->content = ($options['readon'] === true)
          ? strip_readon($article)
          : remove_readon($article);
      }

      return view(
        "Themes\\$this->theme\\cells\\category\\category",
        [
          'category' => $category,
          'articles' => $articles
        ]
      );
    }

    return '';
  }
}
