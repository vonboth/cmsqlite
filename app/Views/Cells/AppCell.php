<?php


namespace App\Views\Cells;

use Admin\Config\SystemSettings;

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
    protected SystemSettings $SystemSettings;

    /** @var string $theme theme configured in configuration */
    protected string $theme;

    /** @var bool $translationEnabled is translation enabled */
    protected $translationEnabled = false;

    /** @var string $locale current locale */
    protected $locale;

    /**
     * AppCell constructor.
     */
    public function __construct()
    {
        $this->SystemSettings = config('Admin\Config\SystemSettings');
        $this->theme = $this->SystemSettings->theme;
        $this->translationEnabled = (bool)$this->SystemSettings->translations;
        $this->locale = service('language')->getLocale();

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
    abstract public function render(array $options = []): string;

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
