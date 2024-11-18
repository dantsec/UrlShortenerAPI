<?php

namespace App\Http\Controllers;

use App\Traits\RequestHandlerTrait;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use RequestHandlerTrait;
}
