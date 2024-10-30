<?php


namespace Admin\Validator;


class UserRules
{
    /**
     * password_length rule when updating the password
     * @param string $str
     * @param string $args
     * @param array $data
     * @param null $error
     * @return bool
     */
    public function password_length(string $str, string $args, array $data, &$error = null)
    {
        if (!empty($data['password']) && !empty($data['password_confirm']) && $data['password'] == $data['password_confirm']) {
            if (strlen($data['password']) >= $args) {
                return true;
            }
            $error = lang('all.validation.password_length', ['param' => $args]);
        } elseif (!empty($data['id']) && empty($data['password'])) {
          return true;
        }
        return false;
    }

    /**
     * validate the password to match certain rules
     *
     * @param string $str
     * @param string $args
     * @param array $data
     * @param null $error
     * @return bool
     */
    public function password_rule(string $str, string $args, array $data, &$error = null)
    {
        if (!empty($data['password']) && !empty($data['password_confirm']) && $data['password'] == $data['password_confirm']) {
            $regex = '/(?=.{' . $args . ',})(?=.*?[^\w\s])(?=.*?[0-9])(?=.*?[A-Z]).*?[a-z].*/';
            if (preg_match($regex, $str)) {
                return true;
            }
            $error = lang('all.validation.password_rule', ['param' => $args]);
        } elseif (!empty($data['id']) && empty($data['password'])) {
          return true;
        }
        return false;
    }
}
