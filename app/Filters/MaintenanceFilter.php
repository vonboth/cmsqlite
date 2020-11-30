<?php


namespace App\Filters;


use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class MaintenanceFilter
 * @package App\Filters
 * Down for maintenance filter
 *
 * Displays a message that the current page
 * is in maintenance mode. You can enable the
 * mode in the admin backend
 */
class MaintenanceFilter implements FilterInterface
{
    /**
     * @inheritdoc
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $systemSettings = config('SystemSettings');
        list($first) = explode('/', $request->detectPath());
        $allowed = in_array($first, ['maintenance', 'admin']);

        if ((bool)$systemSettings->maintenance && !$allowed) {
            return redirect('maintenance');
        }
    }

    /**
     * @inheritdoc
     *
     * @return void
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}