<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\UsersModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Index
 * @package Admin\Controllers
 * @property ArticlesModel $Articles
 * @property UsersModel $Users
 */
class StartController extends BaseController
{
    /** @var string $controllerName */
    protected string $controllerName = 'Start';

    /** @var ArticlesModel $Articles */
    protected $Articles;

    /** @var UsersModel $Users */
    protected UsersModel $Users;

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
    public function index(): string
    {
        $startArticle = $this->Articles
            ->where(['is_startpage' => 1])
            ->get();
        $users = $this->Users
                ->asArray()
                ->orderBy('lastlogin', 'ASC')
                ->findAll(3);
        $lastEditedArticles = $this->Articles
                ->asArray()
                ->orderBy('updated', 'DESC')
                ->findAll(3);
        $topArticles = $this->Articles
                ->asArray()
                ->where('hits >', 0)
                ->orderBy('hits', 'DESC')
                ->findAll(3);

        if (is_dir(ROOTPATH . 'install')
            && getenv('CI_ENVIRONMENT' === 'production')
            && file_exists(ROOTPATH . '.env')
        ) {
            $this->session->setFlashdata(['flash' => lang('admin.admin.remove_install_folder')]);
        }

        return view(
            'Admin\Views\Start\start.php',
            compact('startArticle', 'users', 'lastEditedArticles', 'topArticles')
        );
    }

    /**
     * reset hits for all articles
     */
    public function resetHits(): RedirectResponse
    {
        $redirect = redirect();
        if ($this->Articles->resetHits()) {
            $redirect->with('flash', lang('admin.admin.success_reset_hits'));
        } else {
            $redirect->with('flash', lang('admin.admin.failed_reset_hits'));
        }

        return $redirect->to('/admin');
    }
}
