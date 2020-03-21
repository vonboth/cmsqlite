<?php


namespace Admin\Controllers;


class Authenticate extends Base
{
    public function login()
    {
        return view('AdminThemes\default\login');
    }

    public function authenticate()
    {
        var_dump('Authenticate');
    }

    public function logout()
    {
        var_dump('Log me out');
    }

}