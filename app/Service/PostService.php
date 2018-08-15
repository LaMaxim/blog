<?php

namespace App\Service;


class PostService
{

    /**
     * Delete image
     *
     * @param $dir
     * @param $nameImage
     */
    public function deleteImage($dir, $nameImage) {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $path) {
            $nameFileWithoutExtension = explode('.', $path->getBasename());
            if ($nameFileWithoutExtension[0] == $nameImage) {
                unlink($path->getPathname());
            }
        }
    }
}