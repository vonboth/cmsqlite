<?php


namespace Admin\Controllers\Resource;


use Admin\Models\Entities\Menu;
use Admin\Models\MenusModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use Psr\Log\LoggerInterface;

/**
 * Class Menus
 * @package Admin\Controllers\Resource
 *
 * @property MenusModel $Menus
 */
class Menus extends ResourceController
{
    protected $modelName = 'Admin\Models\MenusModel';
    protected $format = 'json';
    private $Menus;

    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);

        $this->Menus = new MenusModel();
    }

    /**
     * @return array|mixed
     */
    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function show($id = null)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            $this->failNotFound(lang('Errors.not_found'));
        }
        return $this->respond($this->model->find($id));
    }

    public function create()
    {
        $menu = new Menu();
        if ($this->validate(['name' => 'required'])) {
            $menu->fill($this->request->getPost());
            if ($this->Menus->insert($menu)) {
                return $this->respondCreated($menu, lang('General.saved'));
            } else {
                return $this->fail(lang('General.save_error'));
            }
        } else {
            return $this->failValidationError(lang('Errors.fail_validation'));
        }
    }

    /**
     * @param null $id
     * @return array|mixed
     * @throws \ReflectionException
     */
    public function update($id = null)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            return $this->failNotFound(lang('Errors.not_found'));
        }

        if ($this->validate(['name' => 'required'])) {
            $menu->fill($this->request->getPost());
            try {
                if ($this->Menus->save($menu)) {
                    return $this->respondUpdated($menu, lang('General.saved'));
                } else {
                    return $this->respond(
                        [
                            'status' => 500,
                            'error' => 500,
                            'messages' => [
                                'error' => lang('General.save_error'),
                                'csrf_hash' => csrf_hash()
                            ]
                        ],
                        500
                    );
                }
            } catch (\Exception $exception) {
                return $this->respond(
                    [
                        'status' => 500,
                        'error' => 500,
                        'messages' => [
                            'error' => $exception->getMessage(),
                            'csrf_hash' => csrf_hash()
                        ]
                    ],
                    500
                );
            }
        } else {
            return $this->fail($this->validator->getErrors());
        }
    }

    /**
     * @param null $id
     * @return array|mixed
     */
    public function delete($id = null)
    {
        $menu = $this->model->find($id);
        if (!$menu) {
            return $this->failNotFound(lang('Errors.not_found'));
        }

        if ($this->model->delete($menu)) {
            return $this->respondDeleted($menu);
        } else {
            return $this->fail(lang('Errors.fail_delete'));
        }
    }
}