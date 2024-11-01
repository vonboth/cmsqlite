<?php


namespace Admin\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Authenticate
 * Controller to handle authentication
 *
 * @package Admin\Controllers
 */
class AuthenticateController extends BaseController
{
    /**
     * shows the login form
     * @return string|RedirectResponse
     */
    public function login()
    {
        if ($this->request->getMethod() === 'POST') {
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
                    ->with('flash', lang('admin.validation.auth_failed'));
            }
        }

        return view(
            "AdminThemes\\$this->theme\\layouts\\login",
            [
                'theme' => $this->theme,
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
