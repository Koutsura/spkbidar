<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PelatihanAdminController extends Controller
{
    public function index()
    {
        return view('layouts.admin.pelatihan.index');
    }
}
