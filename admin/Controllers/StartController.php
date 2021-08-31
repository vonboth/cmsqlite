<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\UsersModel;

/**
 * Class Index
 * @package Admin\Controllers
 * @property ArticlesModel $Articles
 * @property UsersModel $Users
 */
class StartController extends BaseController
{
    protected string $controllerName = 'Start';

    /** @var ArticlesModel $Articles */
    protected $Articles;

    /** @var UsersModel $Users */
    protected $Users;

    /**
     * Initialize controller
     */
    public function initialize(): void
    {
        $this->Articles = new ArticlesModel();
        $this->Users = new UsersModel();
    }

    /**
     * Index action
     * @return string
     */
    public function index()
    {
        $startArticle = $this->Articles
            ->where(['is_startpage' => 1])
            ->get();
        $users = $this->Users
            ->orderBy('lastlogin', 'ASC')
            ->findAll(3);
        $lastEditedArticles = $this->Articles
            ->orderBy('updated', 'DESC')
            ->findAll(3);
        $topArticles = $this->Articles
            ->orderBy('hits', 'DESC')
            ->findAll(3);

        return view(
            'Admin\Views\Start\start.php',
            compact('startArticle', 'users', 'lastEditedArticles', 'topArticles')
        );
    }

    /**
     * reset hits for all articles
     */
    public function resetHits()
    {
        $redirect = redirect();
        if ($this->Articles->resetHits()) {
            $redirect->with('flash', lang('Admin.success_reset_hits'));
        } else {
            $redirect->with('flash', lang('Admin.failed_reset_hits'));
        }

        return $redirect->to('/admin');
    }
}