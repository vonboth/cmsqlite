<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Article;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property ArticlesModel $Articles
 * @property CategoriesModel $Categories
 */
class ArticlesController extends BaseController
{
  /**
   * init controller
   */
  public function initialize(): void
  {
    $this->Articles = new ArticlesModel();
    $this->Categories = new CategoriesModel();
  }

  /**
   * index action / entry point
   * @return string
   */
  public function index(): string
  {
    return view(
      'Admin\Articles\index',
      [
        'articles' => $this->Articles->with('categories')->findAll(),
        'categories' => $this->Categories->findList(),
      ]
    );
  }

  /**
   * view item
   * @param null $id
   * @return string
   */
  public function view($id = null)
  {
    return view(
      'Admin\Articles\view',
      [
        'article' => $this->Articles->find($id),
        'categories' => $this->Categories->findList(),
      ]
    );
  }

  /**
   * add item
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   * @throws \ReflectionException
   */
  public function add()
  {
    $article = new Article(['published' => 1]);
    if ($this->request->getMethod() === 'post') {
      if ($this->validate(['title' => 'required', 'content' => 'required'])) {
        $article->fill($this->request->getPost());
        if ($this->Articles->insert($article) !== false) {
          return redirect()
            ->to('/admin/articles/edit/' . $this->Articles->getInsertID())
            ->with('flash', lang('General.saved'));
        } else {
          return redirect()
            ->back()
            ->withInput()
            ->with('flash', lang('General.save_error'));
        }
      } else {
        return redirect()
          ->back()
          ->withInput();
      }
    }

    return view(
      'Admin\Articles\add',
      [
        'categories' => $this->Categories->findList(),
        'article' => $article,
        'validator' => $this->validator,
      ]
    );
  }

  /**
   * edit / update item
   * @param null $id
   * @return \CodeIgniter\HTTP\RedirectResponse|string
   * @throws \ReflectionException
   */
  public function edit($id = null)
  {
    $article = $this->Articles->find($id);
    if ($this->request->getMethod() === 'post') {
      if ($this->validate([
        'title' => 'required',
        'content' => 'required'
      ])) {
        $article->fill($this->request->getPost());
        if ($this->Articles->save($article)) {
          return redirect()
            ->to('/admin/articles/edit/' . $id)
            ->with('flash', lang('General.saved'));
        } else {
          return redirect()
            ->to('/admin/articles/edit/' . $id)
            ->withInput()
            ->with('flash', lang('General.save_error'));
        }
      } else {
        return redirect()
          ->to('/admin/articles/edit/' . $id)
          ->withInput();
      }
    }

    return view(
      'Admin\Articles\edit',
      [
        'article' => $article,
        'categories' => $this->Categories->findList(),
        'validator' => $this->validator,
      ]
    );
  }

  /**
   * delete / remove item
   * @param $id
   * @return \CodeIgniter\HTTP\RedirectResponse
   */
  public function delete($id)
  {
    if ($this->Articles->delete($id)) {
      return redirect()
        ->back()
        ->with('flash', lang('General.deleted'));
    } else {
      return redirect()
        ->back()
        ->with('flash', lang('General.delete_error'));
    }
  }
}
