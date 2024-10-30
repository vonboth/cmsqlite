<?php


namespace Admin\Validator;


class MenuitemRules
{
    /**
     * test if the article_id or the url is set
     * dependent on the type chosen
     *
     * @param string|null $str
     * @param string $args
     * @param array $data
     * @param null|string $error
     * @return bool
     */
    public function required_if($str, $args, array $data, &$error)
    {
        if ($args == 'article_id') {
            if ($data['type'] == 'article' && empty($data['article_id'])) {
                $error = lang('all.validation.article_required');
                return false;
            }
            return true;
        } elseif ($args == 'category_id') {
            if ($data['type'] == 'category' && empty($data['category_id'])) {
                $error = lang('all.validation.category_required');
                return false;
            }
            return true;
        } elseif ($args == 'url') {
            if ($data['type'] == 'other' && empty($data['url'])) {
                $error = lang('all.validation.url_required');
                return false;
            }
            return true;
        }

        return true;
    }
}
