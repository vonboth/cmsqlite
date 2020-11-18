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
 * e.g.: view_cell("Views\Cells\Article::render, ['id' => 1]")
 * e.g.: view_cell("Views\Cells\Article::render, ['alias' => 'startpage']")
 *
 * You need to know the ID and/or the alias from the database or
 * the CMSQLite-Backend
 */
class Article extends AppCell
{
    /**
     * render method to create the output
     * @param array $options
     * @return string
     */
    public function render(array $options = []): string
    {
        $Articles = new ArticlesModel();
        $output = '';

        $article = null;
        if (isset($options['id'])) {
            $article = $Articles->find($options['id']);
        } elseif (isset($options['alias'])) {
            $article = $Articles
                ->where('alias', $options['alias'])
                ->first();
        }
        if ($article) {
            $output = $article->content;
            $article->hits++;
            try {
                if (!$article->is_startpage) {
                    $Articles->save($article);
                }
            } catch (\Exception $exception) {
            }
        }

        return $output;
    }
}