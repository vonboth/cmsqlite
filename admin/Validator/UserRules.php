<?php


namespace Admin\Validator;


class UserRules
{
    /**
     * Password Update validation
     *
     * @param string $str
     * @param string $vars
     * @param array $data
     * @return bool
     */
    public function password_update(string $str, string $vars, array $data): bool
    {
        $vars = explode(',', $vars);

        //if password is not set, dismiss validation
        if (trim($str) == '') {
            return true;
        }
        // length fullfilled?
        if (!(intval($vars[0]) <= mb_strlen($str))) {
            return false;
        }
        // password_cofirmed set?
        if (!array_key_exists($vars[1], $data)) {
            return false;
        }

        $vars = $vars[0]; // can only handle one parameter in the message
        // matches password_confirm
        return ($str === $data[$vars[1]]);
    }
}