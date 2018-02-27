<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    protected $JustifAccepted = ["pdf", "jpg", "jpeg", "png", "zip"];

    protected $LogoAccepted = ["jpg", "jpeg", "png", "tiff"];
	
    
}
