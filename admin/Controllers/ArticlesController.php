<?php


namespace Admin\Controllers;


use Admin\Models\ArticlesModel;
use Admin\Models\CategoriesModel;
use Admin\Models\Entities\Article;
use Admin\Models\Entities\Translation;
use Admin\Models\TranslationsModel;

/**
 * Class Articles
 * @package Admin\Controllers
 * @property ArticlesModel $Articles
 * @property TranslationsModel $Translations
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
        $this->Translations = new TranslationsModel();
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
                'articles' => $this->Articles->with(['categories'])->findAll(),
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
                'article' => ($this->SystemSettings->translations
                    ? $this->Articles->findWithTranslations($id)
                    : $this->Articles->find($id)),
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
        if ($this->request->getMethod() === 'post') {
            $translationsEnabeld = $this->SystemSettings->translations;
            $validation = [
                'title' => 'required',
                'content' => 'required'
            ];

            if ($translationsEnabeld) {
                $validation += [
                    'translations.*.content' => 'required',
                    'translations.*.title' => 'required'
                ];
            }

            if ($this->validate($validation)) {
                $postData = $this->request->getPost();
                $article = new Article();
                $article->fill($postData);
                if ($this->Articles->insert($article) !== false) {
                    $id = $this->Articles->getInsertID();
                    if ($translationsEnabeld) {
                        foreach ($postData['translations'] as $formData) {
                            $translationEntity = new Translation();
                            $translationEntity->fill($formData);
                            $translationEntity->article_id = $id;
                            $this->Translations->insert($translationEntity);
                        }
                    }

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

        $article = (new Article(['published' => 1]))->toArray();
        if ($this->SystemSettings->translations) {
            $translationLanguages = array_diff(
                config('Admin\SystemSettings')->supportedTranslations,
                [config('Admin\SystemSettings')->language]
            );
            foreach ($translationLanguages as $language) {
                $article['translations'][$language] = (new Translation(['language' => $language]))->toArray();
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
        if ($this->request->getMethod() === 'post') {
            $article = $this->Articles->find($id);
            $translationsEnabled = $this->SystemSettings->translations;
            $validations = [
                'title' => 'required',
                'content' => 'required'
            ];

            if ($translationsEnabled) {
                $validations += [
                    'translations.*.content' => 'required',
                    'translations.*.title' => 'required'
                ];
            }

            if ($this->validate($validations)) {
                $postData = $this->request->getPost();
                $article->fill($postData);
                if ($this->Articles->save($article)) {
                    if ($translationsEnabled) {
                        foreach ($postData['translations'] as $formData) {
                            if (!empty($formData['id'])) {
                                $translationEntity = $this->Translations->find($formData['id']);
                                $translationEntity->fill($formData);
                                $this->Translations->save($translationEntity);
                            } else {
                                $translationEntity = new Translation();
                                $translationEntity->fill($formData);
                                $translationEntity->article_id = $id;
                                $this->Translations->insert($translationEntity);
                            }
                        }
                    }

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
                'article' => ($this->SystemSettings->translations
                    ? $this->Articles->findWithTranslations($id)
                    : $this->Articles->find($id)),
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
