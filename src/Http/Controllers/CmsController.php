<?php

namespace Studiosidekicks\Alfred\Http\Controllers;

use Illuminate\Routing\Controller;

class CmsController extends Controller
{
    public function index()
    {
        return view('alfred::cms.master');
    }
}