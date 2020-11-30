<?php


namespace Admin\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

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
    public function login(): string
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
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        $this->AuthService->logout();
        return redirect('/');
    }
}