<?php


namespace Views\Cells;

use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;
use App\Views\Cells\AppCell;

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
            ->get()
            ->getResult();

        if ($articles) {
            // remove the readon if necessary
            if ($options['readon'] === true) {
                foreach ($articles as $article) {
                    $article->content = $this->_stripReadon($article);
                }
            }

            return view(
                "Themes\\$this->layout\\cells\\category\\category",
                [
                    'category' => $category,
                    'articles' => $articles
                ]
            );
        }

        return '';
    }

    /**
     * @param $article
     * @return string
     */
    private function _stripReadon($article)
    {
        $output = $article->content;
        $pos = strpos($output, '<hr class="readon" />');
        if ($pos !== false) {
            $output = substr($output, 0, $pos);
            $output .= view(
                "Themes\\$this->layout\\cells\\readon\\readon",
                ['article' => $article]
            );
        }

        return $output;
    }
}