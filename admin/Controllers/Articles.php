<?php


namespace Admin\Controllers;


use App\Models\ArticlesModel;
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
        $article = $this->Articles->find($id);
        return view(
            'Admin\Articles\view',
            compact('article')
        );
    }

    public function add()
    {
        $article = new ArticlesModel();
        $errors = [];

        if ($this->request->getMethod() === 'post') {
            if (!$this->validate([])) {
                $errors = $this->validator->getErrors();
            }
        }

        return view('Admin\Articles\add', [
            'article' => $article,
            'errors' => $errors
        ]);
    }

    public function edit($id = null)
    {
        $article = $this->Articles->find($id);
        return view(
            'Admin\Articles\edit',
            compact('article')
        );
    }

    public function delete($id)
    {
        return redirect('admin/articles');
    }
}