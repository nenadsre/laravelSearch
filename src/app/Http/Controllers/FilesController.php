<?php
/**
 * FilesController
 *
 * PHP version 7.3
 *
 * @category Controllers
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */


namespace App\Http\Controllers;

use App\Managers\FileManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * FilesController
 *
 * PHP version 7.3
 *
 * @category Controllers
 * @package  LaravelProject
 * @author   Nenad <nenad.sredojevic@gmail.com>
 */
class FilesController extends Controller {


    /**
     * File manager
     *
     * @var FileManager
     */
    private $fileManager;

    /**
     * Constructor
     */
    public function __construct() {
        $this->fileManager = new FileManager();
    }


    /**
     * Add and update file action
     *
     * @param Request $request request
     *
     * @return Response
     */
    public function addFile(Request $request): Response {
        return new Response($this->fileManager->addOrUpdateFile(json_decode($request->getContent())));
    }

    /**
     * Delete file action
     *
     * @param Request $request request
     *
     * @return Response
     */
    public function deleteFile(Request $request): Response {
        return new Response($this->fileManager->removeFile(json_decode($request->getContent())));

    }

    /**
     * Search file
     *
     * @param Request $request request
     *
     * @return Response
     */
    public function searchFile(Request $request): Response {
        return new Response($this->fileManager->searchFile(json_decode($request->getContent())));

    }



}
