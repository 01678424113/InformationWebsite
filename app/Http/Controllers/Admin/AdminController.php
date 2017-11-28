<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    //
    public function index()
    {
        $response = [
            'title'=>'',
            'page'=>'home'
        ];
        return view('admin.page.index',$response);
    }


}
