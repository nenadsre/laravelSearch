<?php
/**
 * FileRepo
 *
 * PHP version 7.3
 *
 * @category Repos
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */


namespace App\Repos;

use App\Models\File;
use Illuminate\Support\Facades\Cache;


/**
 * FileRepo
 *
 * PHP version 7.3
 *
 * @category Repos
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */
class FileRepo {


    /**
     * Insert file
     *
     * @param string $fileName name
     * @param string $path     path
     * @param int    $version  version
     *
     * @return File/null
     */
    public static function insertFile(string $fileName, string $path, int $version = 1): ?File {
        $query = [
            'name'    => $fileName,
            'path'    => $path,
            'version' => $version
        ];

        //check if exists;
        if (!File::firstWhere($query)) {
            return File::create($query);
        }
        return null;
    }

    /**
     * Remove file
     *
     * @param string $fileName name
     * @param string $path     path
     * @param int    $version  version
     *
     * @return void
     */
    public static function removeFile(string $fileName, string $path, int $version = 1): void {
        $query = [
            'name'    => $fileName,
            'path'    => $path,
            'version' => $version
        ];

        if ($file = File::firstWhere($query)) {
            $file->delete();
        }
    }

    /**
     * File search by file name
     *
     * @param string $term term
     *
     * @return array
     */
    public static function filenameSearch(string $term): array {
        return Cache::remember("filenames.{$term}", $minutes = '60', function () use ($term) {
            return File::where('name', 'LIKE', '%' . $term . '%')->pluck('id')->toArray();
        });
    }

    /**
     * Fetch collection and format it
     *
     * @param array $fileIds file ids
     *
     * @return array
     */
    public static function fetchAndFormat(array $fileIds): array {
        $fileCollection = File::whereIn('id', $fileIds)->get();
        $result         = [];
        foreach ($fileCollection as $file) {
            $result[] = $file->path . '/' . $file->name;
        }
        return $result;
    }

}