<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Session;
use Auth;
use DB;
class MethodController extends Controller
{

    public function index()
    {
        return view('pages.methods.index');
    }

}
