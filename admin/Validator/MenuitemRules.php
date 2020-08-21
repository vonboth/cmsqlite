<?php


namespace Admin\Validator;


class MenuitemRules
{
    /**
     *
     * @param string $str
     * @param string $vars
     * @param array $data
     * @return bool
     */
    public function required_if(string $str, string $vars, array $data)
    {
        return true;
    }
}