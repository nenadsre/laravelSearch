<?php
/**
 * FileManager
 *
 * PHP version 7.3
 *
 * @category Managers
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */


namespace App\Managers;

use App\Repos\FileRepo;
use App\Repos\SearchTermRepo;
use Illuminate\Support\Facades\Cache;

/**
 * FileManager
 *
 * PHP version 7.3
 *
 * @category Managers
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */
class FileManager {

    /**
     * Add/update file
     *
     * @param \stdClass $data request data
     *
     * @return string[]
     */
    public function addOrUpdateFile(\stdClass $data): array {
        $fileName = $data->name;
        $path     = $data->path;
        $version  = $data->version ?? 1;
        $content  = $data->content ?? '';

        //new file or new version
        if ($file = FileRepo::insertFile($fileName, $path, $version)) {
            $terms = self::parseConntent($content);
            SearchTermRepo::addSSearchTerms($file->id, $terms);
        }
        return ['OK'];
    }

    /**
     * Remove File
     *
     * @param \stdClass $data data
     *
     * @return string[]
     */
    public function removeFile(\stdClass $data) {
        $fileName = $data->name;
        $path     = $data->path;
        $version  = $data->version ?? 1;
        FileRepo::removeFile($fileName, $path, $version);
        Cache::flush();
        return ['ok'];
    }

    /**
     * Search by term
     *
     * @param \stdClass $data request data
     *
     * @return array
     */
    public function searchFile(\stdClass $data): array {
        $term           = $data->term ?? '';
        $filenameResult = FileRepo::filenameSearch($term);
        $termsResult    = SearchTermRepo::search($term);
        $fileIds        = array_unique(array_merge($filenameResult, $termsResult));

        return FileRepo::fetchAndFormat($fileIds);
    }


    /**
     * Split content into words
     *
     * @param string $content file content
     *
     * @return array
     */
    private static function parseConntent(string $content): array {
        return array_unique(preg_split("/[\s,]+/", $content));
    }

}