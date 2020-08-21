<?php


namespace Admin\Controllers;

use Admin\Models\Entities\Menuitem;
use Admin\Models\MenuitemsModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Menuitems
 * @package Admin\Controllers
 * @property MenuitemsModel $Menuitems;
 */
class Menuitems extends Base
{
    /** @var MenuitemsModel $Menuitems */
    protected $Menuitems;

    /**
     * init controller
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param LoggerInterface $logger
     */
    public function initController(
        RequestInterface $request,
        ResponseInterface $response,
        LoggerInterface $logger
    ) {
        parent::initController($request, $response, $logger);
        $this->Menuitems = new MenuitemsModel();
    }

    /**
     * add menu item
     * @return \CodeIgniter\HTTP\RedirectResponse
     * @throws \ReflectionException
     */
    public function add()
    {
        // TODO: required_if rule programmieren
        $item = new Menuitem();
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(
                [
                    'title' => 'required',
                    'menu_id' => 'required',
                    'type' => 'in_list[article,other]',
                    'article_id' => 'required_if[type,article]',
                    'url' => 'required_if[type,other]'
                ]
            )) {
                $item->fill($this->request->getPost());
                if ($this->Menuitems->insert($item) !== false) {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->with('flash', lang('General.saved'));
                } else {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->with('flash', lang('General. save_error'));
                }
            } else {
                return redirect()
                    ->to('/admin/menus/index')
                    ->withInput()
                    ->with('validator', $this->validator);
            }
        }

        return redirect()
            ->to('/admin/menus/index')
            ->with('flash', 'Not Implemented');
    }

    /**
     * edit menuitem
     * @param null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function edit($id = null)
    {
        $item = $this->Menuitems->find($id);
        if ($this->request->getMethod() === 'post') {
            if ($this->validate([])) {
                $item->fill($this->request->getPost());
                try {
                    if ($this->Menuitems->save($item)) {
                        return redirect()
                            ->to('/admin/menus/index')
                            ->with('flash', lang('General.saved'));
                    } else {
                        return redirect()
                            ->to('/admin/menus/index')
                            ->with('flash', lang('General. save_error'));
                    }
                } catch (\Exception $exception) {
                    return redirect()
                        ->to('/admin/menus/index')
                        ->with('flash', $exception->getMessage());
                }
            } else {
                return redirect()
                    ->to('/admin/menus/index')
                    ->with('validator', $this->validator);
            }
        }
        return redirect()
            ->to('/admin/menus/index')
            ->with('flash', 'Not implemented');
    }

    /**
     * delete menu item
     * @param null $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id = null)
    {
        if ($this->Menuitems->delete($id)) {
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.deleted'));
        } else {
            return redirect()
                ->to('/admin/menus/index')
                ->with('flash', lang('General.delete_error'));
        }
    }
}