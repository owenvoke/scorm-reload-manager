<?php

namespace pxgamer\ScormReload\Traits;

/**
 * Trait RecursivelyDeletes
 */
trait RecursivelyDeletes
{
    /**
     * Recursively delete files and folders from a directory
     *
     * @param string $sDirectory
     * @param array  $ignoredData
     * @return array|bool
     */
    protected function recursiveDelete(string $sDirectory, array $ignoredData = [])
    {
        if (!is_dir($sDirectory)) {
            return false;
        }

        $oCourseDirectories = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $sDirectory,
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        $aRemoved = [
            'directories' => 0,
            'files'       => 0,
        ];

        /** @var \RecursiveDirectoryIterator $path */
        foreach ($oCourseDirectories as $path) {
            if (in_array($path->getBasename(), $ignoredData)) {
                continue;
            }

            if ($path->isDir() && !$path->isLink()) {
                rmdir($path->getPathname());
                $aRemoved['directories']++;
            } else {
                unlink($path->getPathname());
                $aRemoved['files']++;
            }
        }

        return $aRemoved;
    }
}