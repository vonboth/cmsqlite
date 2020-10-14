<?php


namespace Views\Cells;

use Admin\Models\ArticlesModel;

/**
 * Class Article
 * @package App\Views\Cells
 *
 * ViewCell to render a single article
 * Pass an array with a key ID with the ID of the article
 * or the alias of the article
 * e.g.: view_cell('ViewCells\Article::render, ['id' => 1]')
 * e.g.: view_cell('ViewCells\Article::render, ['alias' => 'startpage']')
 *
 * You need to know the ID and/or the alias from the database or
 * the CMSQLite-Backend
 */
class Article
{
    /**
     * render method to create the output
     * @param array $params
     * @return string
     */
    public function render(array $params = [])
    {
        $Articles = new ArticlesModel();
        $output = '';

        $article = null;
        if (isset($params['id'])) {
            $article = $Articles->find($params['id']);
        } elseif (isset($params['alias'])) {
            $article = $Articles
                ->where('alias', $params['alias'])
                ->first();
        }
        if ($article) {
            $output = $article->content;
        }

        return $output;
    }

    /**
     * __call to catch any class function call
     * or miss-spelling in the template
     * to redirect it to the render method
     * @param $name
     * @param $arguments
     * @return string
     */
    public
    function __call(
        $name,
        $arguments
    ) {
        return $this->render($arguments);
    }
}