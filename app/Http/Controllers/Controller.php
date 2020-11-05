<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $pagination = 15;
    public function image($photo, $path)
    {
        $root = base_path() . '/public/upload/' . $path;
        $name = str_random(20) . "." . $photo->getClientOriginalExtension();
        $mimetype = $photo->getMimeType();
        $explode = explode("/", $mimetype);
        $type = $explode[0];
        if (!file_exists($root)) {
            mkdir($root, 0777, true);
        }
        $photo->move($root, $name);
        return $path = "public/upload/" . $path . "/" . $name;
    }
}
