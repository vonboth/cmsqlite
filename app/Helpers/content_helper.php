<?php

if (!function_exists('remove_readon')) {
    /**
     * Strips the "readon" from the content
     * @param object|\Admin\Models\Entities\Article $article
     * @return string
     */
    function remove_readon(object $article)
    {
        return str_replace('<hr class="readon" />', '', $article->content);
    }
}

if (!function_exists('strip_readon')) {
    /**
     * Strips the content up to the readon
     * and appends the "readon"-Template from
     * THEME/cells/readon/readon
     *
     * @param object $article
     * @return string
     */
    function strip_readon(object $article)
    {
        $settings = config('Admin\Config\SystemSettings');
        $theme = $settings->theme;
        $output = $article->content;
        $pos = strpos($output, '<hr class="readon" />');

        if ($pos !== false) {
            $output = substr($output, 0, $pos);
            $output .= view(
                "Themes\\$theme\\cells\\readon\\readon",
                ['article' => $article]
            );
        }
        return $output;
    }
}
