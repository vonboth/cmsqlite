<?php


namespace Admin\Controllers;

use Admin\Config\Media;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Class Media
 * @package Admin\Controllers
 */
class MediaController extends BaseController
{
    use ResponseTrait;

    /** @var string $mediaPath path to media folder */
    protected $mediaPath = WRITEPATH . 'media/';

    /** @var array $currentPath an array to store children folders */
    protected $currentPath = [];

    /** @var Media $mediaConfig config from Media config file */
    protected $mediaConfig;

    /**
     * init controller
     */
    public function initialize(): void
    {
        /** @var Media mediaConfig */
        $this->mediaConfig = new Media();
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

        $directoryContent = $this->_makeDirectoryStructure(directory_map($this->mediaPath), '/');

        return view(
            'Admin\Media\index',
            [
                'section' => lang('all.menu.media'),
                'currentPath' => $this->currentPath,
                'dirs' => $contents['dirs'],
                'files' => $contents['files'],
                'directoryContent' => $directoryContent,
                'validator' => $this->validator
            ]
        );
    }

    /**
     * Upload file action
     * @return ResponseInterface
     */
    public function upload(): ResponseInterface
    {
        // method is post
        if ($this->request->getMethod() === 'POST') {
            // get file
            $file = $this->request->getFile('file');

            // is file valid
            if ($file->isValid()) {
                $ext = $file->getExtension();
                $mime = $file->getMimeType();

                // allowed file extensions
                if (!in_array($ext, $this->mediaConfig->allowedExtensions)) {
                    return response()
                        ->setStatusCode(422)
                        ->setJSON([
                            'errors' => [lang('all.media.filetype_not_allowed')]
                        ]);
                }

                // allowed mime-types
                if (!in_array($mime, $this->mediaConfig->allowedMimeTypes)) {
                    return response()
                        ->setStatusCode(422)
                        ->setJSON([
                            'errors' => [lang('all.media.mimetype_not_allowed')]
                        ]);
                }

                // try to move the uploaded file to it's location
                try {
                    $path = $this->request->getPost('path') ?: '';
                    if (!empty($path) && $path[0] !== '/') {
                        $path = '/' . $path;
                    }
                    $file->move(WRITEPATH . 'media' . $path);
                    return response()->setJSON([
                        'message' => lang('all.media.upload_success'),
                        'name' => $file->getName()
                    ]);
                } catch (\Exception $exception) {
                    return response()
                        ->setStatusCode(500)
                        ->setJSON([
                            'errors' => [$exception->getMessage()]
                        ]);
                }
            } else {
                return response()
                    ->setStatusCode(500)
                    ->setJSON([
                        'errors' => [$file->getErrorString()]
                    ]);
            }
        }

        return response()
            ->setStatusCode(405);
    }

    /**
     * unlink a file from the file system
     */
    public function removeFile(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getJSON();
            $path = $data->path;
            $filename = $data->delete_file;

            if (substr($path, -1) !== '/') {
                $path .= '/';
            }

            if (!$filename || !file_exists(WRITEPATH . 'media/' . $path . $filename)) {
                return response()->setStatusCode(404)
                    ->setJSON([
                        'errors' => ['not found' => lang('all.media.file_not_exist')]
                    ]);
            }


            if (!unlink(WRITEPATH . 'media/' . $path . $filename)) {
                return $this->response->setStatusCode(500)
                    ->setJSON([
                        'errors' => ['delete' => lang('all.media.file_delete_error')]
                    ]);
            }

            return response()->setJSON([
                'message' => lang('all.media.file_delete_success')
            ]);
        }

        return response()->setStatusCode(405);
    }

    /**
     * remove directory
     */
    public function removeDir(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getJSON();
            $path = $data->path;
            $dir = $data->dir_name;

            if (!empty($path) && substr($path, -1) !== '/') {
                $path .= '/';
            }

            if (!$dir || !is_dir(WRITEPATH . 'media/' . $path . $dir)) {
                return response()->setStatusCode(404)
                    ->setJSON([
                        'errors' => ['not found' => lang('all.media.dir_not_exist')]
                    ]);
            }

            try {
                if (!rmdir(WRITEPATH . 'media/' . $path . $dir)) {
                    return response()->setStatusCode(500)
                        ->setJSON([
                            'errors' => ['media_file' => lang('all.media.dir_delete_error')]
                        ]);
                }

                return response()->setJSON([
                    'message' => lang('all.media.dir_delete_success')
                ]);
            } catch (\Exception $exception) {
                return response()
                    ->setStatusCode(500)
                    ->setJSON([
                        'errors' => ['media_file' => lang('all.media.dir_not_empty')]
                    ]);
            }
        }

        return response()->setStatusCode(405);
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
                // exclude hidden files (e.g. .gitignore)
                if (strpos($entry->getFilename(), '.') === 0) {
                    continue;
                }
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
    public function createFolder(): ResponseInterface
    {
        if ($this->request->getMethod() === 'POST') {
            $data = $this->request->getJSON();
            $name = $data->dir_name;
            $path = $data->path;

            if (empty($name)) {
                return response()
                    ->setStatusCode(422)
                    ->setJSON([
                        'errors' => [lang('all.media.create_dir_error')]
                    ]);
            }

            if (empty($path)) {
                $path = '';
            }

            if (substr($path, -1) !== '/') {
                $path .= '/';
            }

            try {
                if (mkdir(WRITEPATH . 'media/' . $path . $name, 0755)) {
                    return response()->setJSON([
                        'message' => lang('all.media.create_dir_success')
                    ]);
                } else {
                    return response()
                        ->setStatusCode(500)
                        ->setJSON([
                            'errors' => [lang('all.media.create_dir_error')]
                        ]);
                }
            } catch (\Exception $exception) {
                return response()
                    ->setStatusCode(500)
                    ->setJSON([
                        'errors' => [$exception->getMessage()]
                    ]);
            }
        }

        return response()
            ->setStatusCode(405);
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
    public function ckupload()
    {
        if ($this->request->getMethod() === 'POST') {
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

        return $this->fail('Method not allowed', 405);
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
                'section' => lang('all.media.browse_files')
            ]
        );
    }

    /**
     * Upload files via Jodit
     */
    public function joditUpload()
    {
        if ($this->request->getMethod() === 'POST') {
            $files = $this->request->getFiles()['files'];
            $uploadedFiles = [];
            $successMessage = 'Files uploaded';
            $errorMessage = 'Failed to upload file(s)';
            $errorCode = 500;
            $hasError = false;

            foreach ($files as $key => $file) {
                $ext = $file->getExtension();

                if (!$file->isValid() || !in_array($ext, $this->mediaConfig->allowedExtensions)) {
                    $hasError = true;
                    $uploadedFiles[] = [
                        'success' => false,
                        'file' => [
                            'name' => $file->getName(),
                            'message' => 'Invalid file',
                            'path' => null
                        ]
                    ];
                }

                try {
                    $file->move($this->mediaPath);
                    $uploadedFiles[] = [
                        'success' => true,
                        'file' => [
                            'name' => $file->getName(),
                            'message' => 'File uploaded',
                            'path' => '/media/' . $file->getName()
                        ]
                    ];
                } catch (\Exception $exception) {
                    $hasError = true;
                    $uploadedFiles[] = [
                        'success' => false,
                        'file' => [
                            'name' => $file->getName(),
                            'message' => $exception->getMessage(),
                            'path' => null
                        ]
                    ];
                }
            }

            $response = [
                'message' => $successMessage,
                'files' => $uploadedFiles
            ];
            if ($hasError) {
                $response['message'] = $errorMessage;
                $response['error'] = $errorCode;
            }

            return $this->respondCreated($response);
        }

        return $this->fail('Method not allowed', 405);
    }

    /**
     * Browse files / images in Media via and for Jodit
     * @return ResponseInterface
     */
    public function joditBrowse()
    {
        $directory = new \RecursiveDirectoryIterator($this->mediaPath);
        $iterator = new \RecursiveIteratorIterator($directory);
        $images = [];
        foreach ($iterator as $item) {
            if (in_array($item->getExtension(), $this->mediaConfig->allowedImages)) {
                $images[] = [
                    'name' => $item->getFilename(),
                    'path' => substr($item->getRealPath(), strpos($item->getRealPath(), '/media'))
                ];
            }
        }

        return $this->response->setJSON([
            'images' => $images
        ]);
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

    /**
     * Builds a directory structure which works
     * better as JSON and for JS
     *
     * @param array $directory_map the current array of the directory
     * @param string $name name of the node/directory
     * @param array $result the final array
     * @param string $path
     * @return array
     */
    private function _makeDirectoryStructure(
        array $directory_map,
        string $name = '/',
        array &$result = [],
        string $path = '/media/'
    ): array {
        $tmp = [
            'name' => $name,
            'type' => 'dir',
            'children' => []
        ];
        foreach ($directory_map as $key => $file) {
            if ($file === 'index.html') {
                continue;
            }
            if (is_string($key) && is_array($file)) {
                $this->_makeDirectoryStructure(
                    $file,
                    str_replace('/', '', $key),
                    $tmp['children'],
                    $path . $key
                );
            } else {
                $tmp['children'][] = [
                    'name' => $file,
                    'path' => $path,
                    'type' => substr($file, strrpos($file, '.') + 1),
                ];
            }
        }

        usort($tmp['children'], function ($a, $b) {
            if ($a['type'] === 'dir' && $b['type'] === 'dir') {
                return $a['name'] <=> $b['name'];
            } elseif ($a['type'] === 'dir' && $b['type'] !== 'dir') {
                return -1;
            } elseif ($a['type'] !== 'dir' && $b['type'] === 'dir') {
                return 1;
            } elseif ($a['type'] !== 'dir' && $b['type'] !== 'dir') {
                return $a['name'] <=> $b['name'];
            }
            return 0;
        });

        $result[] = $tmp;

        return $result;
    }
}
