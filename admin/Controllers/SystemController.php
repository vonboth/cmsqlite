<?php

namespace Admin\Controllers;

class SystemController extends BaseController
{
    public function index()
    {
        return view('Admin\System\index');
    }

    /**
     * Run a migration
     * @return void
     */
    public function migrate()
    {
        $output = command('migrate');
    }

    /**
     * clear cache
     * @return void
     */
    public function clearCache()
    {
        $output = command('cache:clear');
    }

    /**
     * clear cache
     * @return void
     */
    public function clearLogs()
    {
        $output = command('cache:logs');
    }


}
