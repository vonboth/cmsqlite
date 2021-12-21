<?php


namespace App\Views\Cells;

/**
 * Class Slider
 * @package App\Views\Cells
 *
 * Renders a slider.
 * The method accepts a "path" to a folder within the
 * /writable/media-Folder of the app.
 * All images in this folder will be displayed.
 *
 * e.g. view_cells('Views\Cells\Slider::render', ['path' => 'slider'])
 * will display all images in the folder /writable/media/slider
 *
 * Don't forget to include the sliders css style-sheet in the head-Section
 * link_tag('themes/frontend/Views/default/cells/slider/slider.css');
 */
class Slider extends AppCell
{
    /** @var string[] $imageExtensions list of allowed images extensions */
    private array $imageExtensions = ['png', 'jpg', 'jpeg', 'webp'];

    /**
     * renders a slider
     *
     * @param array $options
     *
     * @return string
     */
    public function render(array $options = []): string
    {
        if (isset($options['path']) && is_dir(WRITEPATH . 'media/' . $options['path'])) {
            $path = WRITEPATH . 'media/' . $options['path'];
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
                        'src' => '/media/' . $options['path'] . '/' . $entry->getFilename(),
                        'name' => $entry->getFilename()
                    ];
                }
            }

            // output if not empty
            if (!empty($images)) {
                return view(
                    "Themes\\$this->theme\cells\slider\slider",
                    [
                        'images' => $images
                    ]
                );
            }
        }

        return '';
    }
}