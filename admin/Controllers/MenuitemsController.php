<?php


namespace Admin\Controllers;

use Admin\Models\Entities\Menuitem;
use Admin\Models\Entities\MenuTranslation;
use Admin\Models\MenuitemsModel;
use Admin\Models\MenusModel;
use Admin\Models\MenuTranslationsModel;
use App\Exceptions\MethodNotAllowedException;
use CodeIgniter\Database\Exceptions\DataException;
use CodeIgniter\HTTP\ResponseInterface;
use SebastianBergmann\CodeCoverage\DeadCodeDetectionNotSupportedException;

/**
 * Class Menuitems
 * @package Admin\Controllers
 * @property MenuitemsModel $Menuitems;
 */
class MenuitemsController extends BaseController
{
    /** @var MenuitemsModel $Menuitems */
    protected $Menuitems;

    /**
     * init controller
     */
    public function initialize(): void
    {
        $this->Menuitems = new MenuitemsModel();
    }

    /**
     * add menu item
     * @return ResponseInterface
     * @throws \ReflectionException
     */
    public function add()
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
            $validations = [
                'title' => 'required',
                'menu_id' => 'required',
                'type' => 'in_list[article,category,other]',
                'article_id' => 'required_if[article_id]',
                'category_id' => 'required_if[category_id]',
                'url' => 'required_if[url]',
                'alias' => 'is_unique[menuitems.alias]',
            ];

            if ($this->SystemSettings->translations) {
                $validations['translations.*.title'] = 'required';
            }

            if ($this->validate($validations)) {
                $post = $this->request->getJSON(true);
                if ($post['type'] == 'article') {
                    $post['url'] = '/pages/' . $post['article_id'];
                }

                $item = new Menuitem();
                $item->fill($post);

                if ($this->Menuitems->insert($item) !== false) {
                    if ($this->SystemSettings->translations) {
                        $MenuTranslations = new MenuTranslationsModel();
                        $id = $this->Menuitems->getInsertID();
                        foreach ($post['translations'] as $data) {
                            $menuTranslation = new MenuTranslation();
                            $menuTranslation->menuitem_id = $id;
                            $menuTranslation->language = $data['language'];
                            $menuTranslation->title = $data['title'];
                            $MenuTranslations->insert($menuTranslation);
                        }
                    }

                    return response()->setJSON([
                        'message' => lang('General.saved'),
                        'data' => $this->Menuitems->findTree($item->menu_id)
                    ]);
                } else {
                    return response()->setStatusCode(422)->setJSON([
                        'errors' => ['any' => lang('General.save_error')],
                        'data' => $item->toArray()
                    ]);
                }
            } else {
                return response()->setStatusCode(422)->setJSON([
                    'errors' => $this->validator->getErrors()
                ]);
            }
        }

        throw new MethodNotAllowedException();
    }

    /**
     * edit menuitem
     * @param null $id
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
            $item = $this->Menuitems->find($id);
            $post = $this->request->getJSON(true);

            $validations = [
                'title' => 'required',
                'menu_id' => 'required',
                'type' => 'in_list[article,other]',
                'article_id' => 'required_if[article_id]',
                'cateogory_id' => 'required_if[category_id]',
                'url' => 'required_if[url]',
                'alias' => 'required|is_unique[menuitems.alias,alias,' . $item->alias . ']'
            ];

            if ($this->SystemSettings->translations) {
                $validations['translations.*.title'] = 'required';
            }


            if ($this->validate($validations)) {
                if ($post['type'] == 'article') {
                    $post['url'] = '/pages/' . $post['article_id'];
                }

                $saved = true;
                $exception = null;

                if ($this->SystemSettings->translations) {
                    $MenuTranslations = new MenuTranslationsModel();
                    foreach ($post['translations'] as $data) {
                        if (!empty($data['id'])) {
                            $menuTranslation = $MenuTranslations->find($data['id']);
                            $menuTranslation->title = $data['title'];
                            try {
                                $MenuTranslations->save($menuTranslation);
                            } catch (DataException $e) {
                            } catch (\Exception $e) {
                                $saved = false;
                                $exception = $e;
                            }
                        } else {
                            try {
                                $menuTranslation = new MenuTranslation();
                                $menuTranslation->fill($data);
                                $MenuTranslations->insert($menuTranslation);
                            } catch (\Exception $e) {
                                $saved = false;
                                $exception = $e;
                            }
                        }
                    }

                    // Translations failed
                    if (!$saved && !is_null($exception)) {
                        return response()->setStatusCode(422)->setJSON([
                            'errors' => ['any' => $exception->getMessage()],
                            'data' => $this->Menuitems->findTree($item->menu_id)
                        ]);
                    }
                }


                $item->fill($post);

                try {
                    $this->Menuitems->save($item);
                } catch (DataException $e) {
                } catch (\Exception $e) {
                    $saved = false;
                    $exception = $e;
                }

                if (!$saved && !is_null($exception)) {
                    return response()->setStatusCode(422)->setJSON([
                        'errors' => ['any' => $exception->getMessage()],
                        'data' => $this->Menuitems->findTree($item->menu_id)
                    ]);
                } else {
                    return response()->setJSON([
                        'message' => lang('General.saved'),
                        'data' => $this->Menuitems->findTree($item->menu_id)
                    ]);
                }
            } else {
                return response()->setStatusCode(422)->setJSON([
                    'errors' => $this->validator->getErrors(),
                    'data' => $post
                ]);
            }
        }

        throw new MethodNotAllowedException();
    }

    /**
     * delete menu item
     * @param int $id
     * @return ResponseInterface
     */
    public function delete($id)
    {
        if ($this->request->isAJAX()) {
            $item = $this->Menuitems->find($id);
            $removeFromTree = (bool)$this->request->getGet('remove_tree');
            if ($this->Menuitems->removeFromTree($id, $removeFromTree)) {
                return response()->setJSON([
                    'message' => lang('General.deleted'),
                    'data' => $this->Menuitems->findTree($item->menu_id)
                ]);
            } else {
                return response()->setStatusCode(422)
                    ->setJSON([
                        'errors' => ['any' => lang('General.delete_error')]
                    ]);
            }
        }

        throw new MethodNotAllowedException();
    }

    /**
     * Move an item in the menu
     * @param null $id
     * @return ResponseInterface
     */
    public function move($id = null)
    {
        if ($this->request->isAJAX() && $this->request->getMethod() === 'post') {
            $post = $this->request->getJSON();
            $item = $this->Menuitems->find($id);

            $result = $post->direction === 'up'
                ? $this->Menuitems->moveUp($id)
                : $this->Menuitems->moveDown($id);

            if ($result) {
                return response()->setJSON([
                    'message' => lang('Menu.node_move_success'),
                    'data' => $this->Menuitems->findTree($item->menu_id)
                ]);
            } else {
                return response()->setStatusCode(422)
                    ->setJSON([
                        'errors' => ['any' => lang('Menus.node_move_error')]
                    ]);
            }
        }

        throw new MethodNotAllowedException();
    }
}
