<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Admin\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //

    public function index()
    {
        $galleries = Gallery::paginate();
        return view('front-end.galleries.index', compact('galleries'));
    }
}
