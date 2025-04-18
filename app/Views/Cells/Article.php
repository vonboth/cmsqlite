<?php


namespace App\Views\Cells;

use Admin\Models\ArticlesModel;

/**
 * Class Article
 * @package App\Views\Cells
 *
 * ViewCell to render a single article
 * Pass an array with a key ID with the ID of the article
 * or the alias of the article
 * e.g.: view_cell("Views\Cells\Article::render, ['id' => 1]")
 * e.g.: view_cell("Views\Cells\Article::render, ['alias' => 'startpage']")
 *  *
 * You need to know the ID and/or the alias from the database or
 * the CMSQLite-Backend
 *
 * allowed options:
 * - id: ID of the article
 * - alias: alias of the article
 * - readon: true | false: cut the text at the "readon"-tag and replace it with a link
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
        $default = ['readon' => false];

        $options = $options + $default;
        $Articles = new ArticlesModel();
        $output = '';

        $article = null;
        if (isset($options['id'])) {
            $article = $Articles
                ->with('translations')
                ->find($options['id']);
        } elseif (isset($options['alias'])) {
            $article = $Articles
                ->with('translations')
                ->where('alias', $options['alias'])
                ->first();
        }
        if ($article) {
            $output = $article->content ?? lang('admin.errors.no_content');

            if ($options['readon'] === true) {
                $pos = strpos($output, '<hr class="readon" />');
                if ($pos !== false) {
                    $output = substr($output, 0, $pos);
                    $output .= view(
                        "Themes\\$this->theme\\cells\\readon\\readon",
                        ['cellArticleId' => $article->id]
                    );
                }
            }

            try {
                if (!$article->is_startpage) {
                    $Articles->setHit($article->id);
                }
            } catch (\Exception $exception) {
            }
        }

        return $output;
    }
}
