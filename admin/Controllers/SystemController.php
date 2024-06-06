<?php

namespace Admin\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class SystemController
 * @package Admin\Controllers
 */
class SystemController extends BaseController
{
    /**
     * Show index page
     * @return string
     */
    public function index()
    {
        return view('Admin\System\index');
    }

    /**
     * Run an update
     * @return RedirectResponse
     */
    public function update(): RedirectResponse
    {
        $output = command('cmsqlite:update');
        return redirect()->to('/admin/system/index')
            ->with('flash', preg_replace('~[[:cntrl:]]~', '', $output));
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
