<?php


namespace Admin\Controllers;


use App\Models\ArticlesModel;
use App\Models\Entities\Article;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property ArticlesModel $Articles
 */
class Articles extends Base
{
    protected $Articles;

    /**
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
        $this->Articles = new ArticlesModel();
    }

    /**
     * @return string
     */
    public function index()
    {
        /** @var  $query */
        $query = $this->db->table('articles')
            ->join('categories', 'articles.category_id = categories.id', 'left')
            ->get();

        return view(
            'Admin\Articles\index',
            ['articles' => $query->getResult()]
        );
    }

    public function view($id = null)
    {
        return view(
            'Admin\Articles\view',
            ['article' => $this->Articles->find($id)]
        );
    }

    public function add()
    {
        $article = new Article();

        if ($this->request->getMethod() === 'post') {
            if ($this->validate(
                [
                    'title' => 'required',
                    'content' => 'required'
                ]
            )) {
                $article->fill($this->request->getPost());
                if ($lastId = $this->Articles->insert($article) !== false) {
                    return redirect("/admin/articles/edit/$lastId")
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
                'article' => $article,
                'validator' => $this->validator
            ]
        );
    }

    public function edit($id = null)
    {
        $article = $this->Articles->find($id);
        if ($this->request->getMethod() === 'post') {
            if ($this->validate(
                [
                    'title' => 'required',
                    'content' => 'required'
                ]
            )) {
                $article->fill($this->request->getPost());
                if ($this->Articles->save($article)) {
                    return redirect()
                        ->back()
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
            'Admin\Articles\edit',
            [
                'article' => $article,
                'validator' => $this->validator
            ]
        );
    }

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