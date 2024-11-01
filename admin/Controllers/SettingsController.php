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
class SettingsController extends BaseController
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
        $settings = array_values($this->Settings->asArray()->findAll());
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
            $setting->fill($this->request->getJSON(true));
            try {
                if ($this->Settings->save($setting)) {
                    session()->setFlashdata('flash', lang('admin.saved'));
                    return $this->respondUpdated($setting);
                } else {
                    session()->setFlashdata('flash', lang('admin.save_error'));
                    return $this->fail(lang('admin.save_error'));
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
                    ->with('flash', lang('admin.saved'));
            } else {
                return redirect()
                    ->to('/admin/settings/index')
                    ->with('flash', lang('admin.save_error'));
            }
        } else {
            return redirect()
                ->to('/admin/settings/index')
                ->with('flash', $this->validator->getErrors())
                ->with('_ci_validation_errors', $this->validator->getErrors());
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
            session()->setFlashdata('flash', lang('admin.deleted'));
            return $this->respondDeleted($setting);
        } else {
            session()->setFlashdata('flash', lang('admin.delete_error'));
            return $this->fail(lang('admin.delete_error'));
        }
    }

    /**
     * Disable the tour
     * @return void
     */
    public function disableTour()
    {
        if ($this->request->isAJAX()) {
            $setting = $this->Settings
                ->where('name', 'tour')
                ->first();
            if ($setting) {
                $setting->value = false;
                try {
                    $this->Settings->save($setting);
                } catch (\Exception $exception) {
                    $this->failServerError('Failed to save');
                }
            }
            $this->respond('true', 200);
        } else {
            $this->fail('not allowed');
        }
    }
}
