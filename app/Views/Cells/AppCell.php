<?php


namespace App\Views\Cells;

/**
 * Class AppCell
 * @package App\Views\Cells
 *
 * Basic Cell class for all CMSQLite view cells
 * TODO: Contact-form cell
 */
abstract class AppCell
{
    /** @var mixed $SystemSettings system settings set in admin backend */
    protected $SystemSettings;

    /** @var string $layout current layout from configuration */
    protected $layout;

    /**
     * AppCell constructor.
     */
    public function __construct()
    {
        $this->SystemSettings = config('Admin\Config\SystemSettings');
        $this->layout = $this->SystemSettings->layout;

        $this->initialize();
    }

    /**
     * renders a view cell
     * Implement this for any child class
     *
     * @param array $options
     *
     * @return string
     */
    abstract public function render(array $options = []) : string;

    /**
     * init cell
     *
     * @return void
     */
    protected function initialize(): void
    {
    }

    /**
     * __call to catch any class function call
     * or miss-spelling in the template
     * to redirect it to the render method
     * @param $name
     * @param $arguments
     * @return string
     */
    public function __call($name, $arguments)
    {
        return $this->render($arguments);
    }
}