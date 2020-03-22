<?php


namespace Admin\Controllers;

/**
 * Class Authenticate
 * Controller to handle authentication
 *
 * @package Admin\Controllers
 */
class Authenticate extends Base
{
    /**
     * shows the login form
     * @return string
     */
    public function login()
    {
        return view('AdminThemes\default\login');
    }

    /**
     * Handles the post request
     * to login a user
     */
    public function authenticate()
    {
    }

    /**
     * Logout user
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        return redirect('/');
    }
}