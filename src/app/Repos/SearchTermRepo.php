<?php
/**
 * SearchTermRepo
 *
 * PHP version 7.3
 *
 * @category Repos
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */


namespace App\Repos;


use App\Models\SearchTerm;
use Illuminate\Support\Facades\Cache;

/**
 * SearchTermRepo
 *
 * PHP version 7.3
 *
 * @category Repos
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */
class SearchTermRepo {

    /**
     * Add search term
     *
     * @param int   $fileId file id
     * @param array $terms  terms
     *
     * @return void
     */
    public static function addSSearchTerms(int $fileId, array $terms): void {
        $data = [];
        foreach ($terms as $term) {
            $data[] = ['term' => $term, 'file_id' => $fileId];
        }
        SearchTerm::insert($data);
    }

    /**
     * Search terms
     *
     * @param string $term terms
     *                     
     * @return array
     */
    public static function search(string $term): array {
        return Cache::remember("term_.{$term}", $minutes = '60', function () use ($term) {
            return SearchTerm::where('term', $term)->pluck('file_id')->toArray();
        });
    }

}