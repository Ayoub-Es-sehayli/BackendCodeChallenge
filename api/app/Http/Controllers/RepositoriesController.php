<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\RepositoriesService;

class RepositoriesController extends Controller
{
    /**
     * GET list of github repositories
     * @return
     **/
    public function index()
    {
        return RepositoriesService::getRepositories();
    }
}
