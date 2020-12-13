<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\Controller;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
}
