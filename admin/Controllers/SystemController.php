<?php

namespace Admin\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class SystemController extends BaseController
{
    public function index()
    {
        return view('Admin\System\index');
    }

    /**
     * Run a migration
     * @return RedirectResponse
     */
    public function migrate(): RedirectResponse
    {
        $output = command('migrate');
        return redirect()->to('/admin/system/index')
            ->with('flash', preg_replace('~[[:cntrl:]]~', '', $output));
    }

    /**
     * clear cache
     * @return RedirectResponse
     */
    public function clearCache(): RedirectResponse
    {
        $output = command('cache:clear');
        return redirect()->to('/admin/system/index')
            ->with('flash', preg_replace('~[[:cntrl:]]~', '', $output));
    }

    /**
     * clear cache
     * @return RedirectResponse
     */
    public function clearLogs(): RedirectResponse
    {
        $output = command('logs:clear --force');
        return redirect()->to('/admin/system/index')
            ->with('flash', preg_replace('~[[:cntrl:]]~', '', $output));
    }


}
