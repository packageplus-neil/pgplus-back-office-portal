<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Utils\ApiResponseHelper;

class BaseController extends Controller
{
    protected $apiResponse;

    public function __construct(ApiResponseHelper $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }
}
