<?php


namespace Views\Cells;

use App\Views\Cells\AppCell;

/**
 * Class Slider
 * @package App\Views\Cells
 *
 * Renders a slider.
 * The method accepts a "path" within the
 * media-Folder in the /public-Folder of the app.
 * All images in this folder will be displayed.
 *
 * e.g. view_cells('ViewCells\Slider::render()', ['path' => 'slider'])
 * will display all images in the folder /public/media/slider
 */
class Slider extends AppCell
{
    /** @var string[] $imageExtensions list of allowed images extensions */
    private array $imageExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    /**
     * renders a slider
     * @param array $params
     * @return string|null
     */
    public function render(array $params = []): string
    {
        if (isset($params['path']) && is_dir(FCPATH . 'media/' . $params['path'])) {
            $path = FCPATH . 'media/' . $params['path'];
            $iterator = new \DirectoryIterator($path);
            $images = [];
            // read images in directory
            foreach ($iterator as $entry) {
                if ($entry->isDot() || $entry->isDir()) {
                    continue;
                }

                $extension = $entry->getExtension();
                if (in_array($extension, $this->imageExtensions)) {
                    $images[] = [
                        'src' => '/media/' . $params['path'] . '/' . $entry->getFilename(),
                        'name' => $entry->getFilename()
                    ];
                }
            }

            // output if not empty
            if (!empty($images)) {
                return view(
                    "Themes\\$this->layout\cells\slider\slider",
                    [
                        'images' => $images
                    ]
                );
            }
        }

        return '';
    }
}