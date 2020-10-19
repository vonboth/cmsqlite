<?php


namespace Views\Cells;

use Admin\Models\ArticlesModel;
use App\Views\Cells\AppCell;

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
class Article extends AppCell
{
    /**
     * render method to create the output
     * @param array $params
     * @return string
     */
    public function render(array $params = []) : string
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
}