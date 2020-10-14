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
        if ($this->request->getMethod() == 'post') {
            if ($this->validate(
                [
                    'username' => 'required|authenticate[password]',
                    'password' => 'required'
                ]
            )) {
                return redirect()
                    ->to('/admin');
            } else {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('flash', lang('Validation.auth_failed'));
            }
        }

        return view(
            'AdminThemes\default\layouts\login',
            [
                'validator' => $this->validator,
            ]
        );
    }

    /**
     * Logout user
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function logout()
    {
        $this->AuthService->logout();
        return redirect('/');
    }
}