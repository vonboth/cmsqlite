<?php

namespace App\Controllers;


use CodeIgniter\HTTP\RedirectResponse;

/**
 * Controller to switch the language
 */
class LanguageController extends BaseController
{
    /**
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if ($lang = $this->request->getGet('lang')) {
            $session = session();
            $session->remove('lang');
            $session->set('lang', $lang);
        }

        return redirect()->to(base_url());
    }
}
