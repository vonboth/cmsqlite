<?php


namespace Admin\Controllers;

use Admin\Models\Entities\Setting;
use Admin\Models\SettingsModel;
use CodeIgniter\API\ResponseTrait;

/**
 * Class Settings
 * @package Admin\Controllers
 * @property SettingsModel $Settings
 */
class Settings extends Base
{
    use ResponseTrait;

    /** @var SettingsModel $Settings */
    protected SettingsModel $Settings;

    /**
     * init controller
     */
    public function initialize(): void
    {
        $this->Settings = new SettingsModel();
    }

    /**
     * index action show inital view
     * @return string
     */
    public function index()
    {
        $settings = $this->Settings->findAll();
        return view('Admin\Settings\index', ['settings' => $settings]);
    }

    /**
     * save a setting
     * @param null|int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function save($id = null)
    {
        $setting = $this->Settings->find($id);
        if ($this->validate(['value' => 'required'])) {
            $setting->fill($this->request->getPost());
            try {
                if ($this->Settings->save($setting)) {
                    session()->setFlashdata('flash', lang('General.saved'));
                    return $this->respondUpdated($setting);
                } else {
                    session()->setFlashdata('flash', lang('General.save_error'));
                    return $this->fail(lang('General.save_error'));
                }
            } catch (\Exception $exception) {
                session()->setFlashdata('flash', $exception->getMessage());
                return $this->fail($exception->getMessage());
            }
        } else {
            return $this->fail($this->validator->getErrors());
        }
    }

    /**
     * Add system setting
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function add()
    {
        $setting = new Setting();
        if ($this->validate(['name' => 'required', 'value' => 'required'])) {
            $setting->fill($this->request->getPost());
            if ($this->Settings->insert($setting) !== false) {
                return redirect()
                    ->to('/admin/settings/index')
                    ->with('flash', lang('General.saved'));
            } else {
                return redirect()
                    ->to('/admin/settings/index')
                    ->with('flash', lang('General.save_error'));
            }
        } else {
            return redirect()
                ->to('/admin/settings/index')
                ->with('flash', $this->validator->getErrors())
                ->with('_ci_validation_errors', serialize($this->validator->getErrors()));
        }
    }

    /**
     * remove a system setting
     * @param null $id
     * @return mixed
     */
    public function delete($id = null)
    {
        $setting = $this->Settings->find($id);
        if ($setting && $this->Settings->delete($id)) {
            session()->setFlashdata('flash', lang('General.deleted'));
            return $this->respondDeleted($setting);
        } else {
            session()->setFlashdata('flash', lang('General.delete_error'));
            return $this->fail(lang('General.delete_error'));
        }
    }
}