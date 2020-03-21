<?php


namespace App\Controllers;


use App\Models\ArticlesModel;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class Page
 * @package App\Controllers
 * @property ArticlesModel $ArticlesModel
 */
class Page extends Base
{
    protected $ArticlesModel = null;

    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->ArticlesModel = new ArticlesModel();
    }

    public function index()
    {
        $articles = $this->ArticlesModel->findAll();

        var_dump($articles);

        $article = $this->ArticlesModel->find(1);
        var_dump($article);
        exit;
    }

}