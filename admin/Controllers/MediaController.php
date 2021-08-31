<?php


namespace Admin\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;

/**
 * Class Media
 * @package Admin\Controllers
 */
class MediaController extends BaseController
{
    use ResponseTrait;

    protected $mediaPath = FCPATH . 'media/';
    protected $currentPath = [];
    protected $mediaConfig;

    /**
     * init controller
     */
    public function initialize(): void
    {
        /** @var \Admin\Config\Media mediaConfig */
        $this->mediaConfig = new \Admin\Config\Media();
    }

    /**
     * Index / entry point for the controller
     * @return string
     */
    public function index(): string
    {
        $dir = $this->request->getGet('dir');
        if (is_null($dir)) {
            $dir = 'root';
        }
        $this->setCurrentPath($dir);
        $scanPath = $this->getCurrentPath();
        $contents = $this->readDirectory($scanPath);

        return view(
            'Admin\Media\index',
            [
                'section' => lang('Menu.media'),
                'currentPath' => $this->currentPath,
                'dirs' => $contents['dirs'],
                'files' => $contents['files'],
                'validator' => $this->validator
            ]
        );
    }

    /**
     * Upload file action
     * @return RedirectResponse
     */
    public function upload(): RedirectResponse
    {
        $response = redirect();

        // method is post
        if ($this->request->getMethod() == 'post') {
            // get file
            $file = $this->request->getFile('media_file');

            // is file valid
            if ($file->isValid()) {
                $ext = $file->getExtension();
                $mime = $file->getMimeType();

                // allowed file extensions
                if (!in_array($ext, $this->mediaConfig->allowedExtensions)) {
                    $this->validator
                        ->setError('media_file', lang('Media.filetype_not_allowed'));

                    $response
                        ->with(
                            '_ci_validation_errors',
                            serialize($this->validator->getErrors())
                        )
                        ->with('flash', lang('Media.invalid_file'));
                }

                // allowed mime-types
                if (!in_array($mime, $this->mediaConfig->allowedMimeTypes)) {
                    $this->validator
                        ->setError('media_file', lang('Media.mimetype_not_allowed'));

                    $response
                        ->with(
                            '_ci_validation_errors',
                            serialize($this->validator->getErrors())
                        )
                        ->with('flash', lang('Media.invalid_file'));
                }

                // try to move the uploaded file to it's location
                try {
                    $path = $this->getCurrentPath();
                    $file->move($path);
                    $response
                        ->with('flash', lang('Media.upload_success'));
                } catch (\Exception $exception) {
                    $this->validator->setError('media_file', $exception->getMessage());

                    $response
                        ->with(
                            '_ci_validation_errors',
                            serialize($this->validator->getErrors())
                        )
                        ->with('flash', lang('Media.upload_error'));
                }
            } else {
                $this->validator
                    ->setError('media_file', $file->getErrorString() . '(' . $file->getError() . ')');
                $response
                    ->with(
                        '_ci_validation_errors',
                        serialize($this->validator->getErrors())
                    )
                    ->with('flash', lang('Media.invalid_file'));
            }
        }
        return $response
            ->back();
    }

    /**
     * unlink a file from the file system
     */
    public function removeFile(): RedirectResponse
    {
        $response = redirect();

        if ($this->request->getMethod() == 'post') {
            $path = $this->getCurrentPath();
            $filename = $this->request->getPost('remove_file');

            if (!$filename || !file_exists($path . '/' . $filename)) {
                $this->validator->setError('media_file', lang('Media.file_not_exist'));
                $response
                    ->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                    ->with('flash', lang('Media.file_not_exist'));
            }

            if (!unlink($path . '/' . $filename)) {
                $this->validator->setError('media_file', lang('Media.file_delete_error'));
                $response
                    ->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                    ->with('flash', lang('Media.file_delete_error'));
            }

            $response->with('flash', lang('Media.file_delete_success'));
        }

        return $response
            ->back();
    }

    /**
     * remove directory
     */
    public function removeDir(): RedirectResponse
    {
        $response = redirect();
        if ($this->request->getMethod() == 'post') {
            $path = $this->getCurrentPath();
            $dir = $this->request->getPost('remove_dir');

            if (!$dir || !is_dir($path . '/' . $dir)) {
                $this->validator->setError('media_file', lang('Media.dir_not_exist'));
                $response
                    ->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                    ->with('flash', lang('Media.dir_not_exist'));
            }

            try {
                if (!rmdir($path . '/' . $dir)) {
                    $this->validator->setError('media_file', lang('Media.dir_delete_error'));
                    $response
                        ->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                        ->with('flash', lang('Media.dir_delete_error'));
                }

                $response->with('flash', lang('Media.dir_delete_success'));
            } catch (\Exception $exception) {
                $this->validator->setError('media_file', lang('Media.dir_not_empty'));
                $response->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                    ->with('flash', lang('Media.dir_not_empty'));
            }
        }
        return $response->back();
    }

    /**
     * reads the directory for the
     * given path
     *
     * @param $path
     * @return array[]
     */
    private function readDirectory(string $path): array
    {
        $dirs = [];
        $files = [];

        $iterator = new \DirectoryIterator($path);
        foreach ($iterator as $entry) {
            if ($entry->isDot()) {
                continue;
            }

            if ($entry->isDir()) {
                $dirs[] = $entry->getFilename();
            } else {
                $extension = $entry->getExtension();
                if (in_array($extension, $this->mediaConfig->doNotDisplay)) {
                    continue;
                }
                $files[] = [
                    'src' => '/media/' . implode('/', $this->currentPath) . '/' . $entry->getFilename(),
                    'name' => $entry->getFilename(),
                    'ext' => $extension,
                    'size' => $entry->getSize()
                ];
            }
        }

        return ['dirs' => $dirs, 'files' => $files];
    }

    /**
     * create a new folder in the
     * current directory
     */
    public function createFolder(): RedirectResponse
    {
        $response = redirect();
        if ($this->request->getMethod() == 'post') {
            $name = $this->request->getPost('dir_name');
            $path = $this->getCurrentPath();
            if (mkdir($path . '/' . $name, 0755)) {
                $response->with('flash', lang('Media.create_dir_success'));
            } else {
                $this->validator->setError('dir_name', lang('Media.create_dir_error'));
                $response
                    ->with('_ci_validation_errors', serialize($this->validator->getErrors()))
                    ->with('flash', lang('Media.create_dir_error'));
            }
        }

        return $response->to('/admin/media/index');
    }

    /**
     * Endpoint to upload images
     * via CKEditor
     *
     * {
     * "uploaded": 1,
     * "fileName": "foo.jpg",
     * "url": "/files/foo.jpg"
     * }
     */
    public function ckupload(): string
    {
        if ($this->request->getMethod() == 'post') {
            $file = $this->request->getFile('upload');
            $ext = $file->getExtension();

            if (!$file->isValid() || !in_array($ext, $this->mediaConfig->allowedExtensions)) {
                return $this->fail('Invalid file', 500);
            }

            try {
                $file->move($this->mediaPath);
                return $this->respondCreated(
                    [
                        'uploaded' => 1,
                        'fileName' => $file->getName(),
                        'url' => '/media/' . $file->getName()
                    ]
                );
            } catch (\Exception $exception) {
                return $this->fail($exception->getMessage(), 500);
            }
        }
    }

    /**
     * Browse all files in the media folder
     * to add them to the content where rquired
     *
     * @return string
     */
    public function ckbrowse()
    {
        $directory = new \RecursiveDirectoryIterator($this->mediaPath);
        $iterator = new \RecursiveIteratorIterator($directory);

        $files = [];
        /** @var \SplFileInfo $item */
        foreach ($iterator as $item) {
            if (in_array($item->getExtension(), $this->mediaConfig->allowedImages)) {
                $files[] = [
                    'name' => $item->getFilename(),
                    'path' => substr($item->getRealPath(), strpos($item->getRealPath(), '/media'))
                ];
            }
        }
        return view(
            'Admin\Media\ckbrowse',
            [
                'files' => $files,
                'section' => lang('Media.browse_files')
            ]
        );
    }

    /**
     * returns a string of the current path
     * @return string
     */
    private function getCurrentPath(): string
    {
        $currentPath = $this->session->get('currentPath');
        $this->currentPath = $currentPath;
        return $this->mediaPath . implode('/', $currentPath);
    }

    /**
     * set the current path into the
     * session to keep track of current
     * folder
     * @param $dir
     */
    private function setCurrentPath($dir): void
    {
        $currentPath = $this->session->get('currentPath');

        if ($dir == 'root') {
            $currentPath = [];
        } elseif ($dir == 'up') {
            array_pop($currentPath);
        } elseif (in_array($dir, $currentPath)) {
            $idx = array_search($dir, $currentPath);
            $currentPath = array_slice($currentPath, 0, $idx + 1);
        } elseif (!in_array($dir, $currentPath)) {
            array_push($currentPath, $dir);
        }

        $this->session->set('currentPath', $currentPath);
    }
}