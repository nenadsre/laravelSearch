<?php
/**
 * CheckJson middleware
 *
 * PHP version 7.3
 *
 * @category Middleware
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * CheckJson middleware
 *
 * PHP version 7.3
 *
 * @category Middleware
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */
class CheckJson {

    /**
     * Obligated keys in json request
     */
    private const KEYS = [
        'path',
        'name'
    ];

    /**
     * Handle an incoming request.
     *
     * @param Request $request request
     * @param Closure $next    next
     *
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        if ($request->getMethod() === 'POST') {
            $val = json_decode($request->getContent(), true);

            if (empty($val) || (array_diff_key(array_flip(self::KEYS), $val) && !array_key_exists('term', $val))) {
                return new Response(
                    [
                        'error_code'    => 101, // add it in some constant list
                        'error_message' => 'Request not valid'
                    ]
                );

            }
            $request->merge((array) json_decode($request->getContent()));
        }
        return $next($request);
    }
}
