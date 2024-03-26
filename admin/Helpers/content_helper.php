<?php

if (!function_exists('vite')) {
    /**
     * vite helper to echo a matching script tag
     * for either develop or production mode
     * @param $script
     * @return string
     */
    function vite($script)
    {
        $url = env('VITE_HOST') . ':' . env('VITE_PORT');

        if (strtolower(env('CI_ENVIRONMENT')) == 'development') {
            return <<<SCRIPT
<script type="module" src="$url/@vite/client"></script>
<script type="module" src="$url/$script"></script>
SCRIPT;
        } else {
            if (file_exists(ROOTPATH . ".vite/manifest.json")) {
                $out = '';
                $manifests = json_decode(file_get_contents(ROOTPATH . '.vite/manifest.json'), true);
                $entries = $manifests[$script];
                foreach ($entries as $key => $entry) {
                    if ($key === 'file') {
                        $out .= "<script type\"module\" src=\"/$entry\"></script>\r\n";
                    }

                    if ($key === 'css') {
                        foreach ($entry as $cssFile) {
                            $out .= "<link rel=\"stylesheet\" href=\"/$cssFile\">\r\n";
                        }
                    }
                }

                return $out;
            }

            throw new Exception('Unable to find vite manifest.json file');
        }
    }
}
