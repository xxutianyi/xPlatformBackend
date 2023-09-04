<?php

namespace App\Utils;

class FileType
{
    public static function get(string $name, string|null $type)
    {
        $extensionList = [
            'gltf' => 'model',
            'glb' => 'model',
            'fbx' => 'model',
            'rfa' => 'family',

            'dwg' => 'drawing',

            'pdf' => 'document',
            'doc' => 'document',
            'docx' => 'document',
            'ppt' => 'slide',
            'pptx' => 'slide',
            'xls' => 'sheet',
            'xlsx' => 'sheet',
            'txt' => 'document',
        ];

        $extension = pathinfo($name, PATHINFO_EXTENSION);

        if (key_exists($extension, $extensionList)) {
            $fileType = $extensionList[$extension];
        } else {
            $fileType = substr($type, 0, strpos($type, '/'));
        }

        if (!$fileType) {
            $fileType = 'unknown';
        }

        return $fileType;

    }
}
