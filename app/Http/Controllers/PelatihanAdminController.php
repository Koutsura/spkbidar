<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PelatihanAdminController extends Controller
{
    public function index()
    {
       $allowedRoles = [
            'alqarib', 'BDCA', 'BDCU', 'BDPRO', 'BDSC', 'BGK',
            'BRadio', 'KMHDI', 'MABIDAR', 'Olahraga', 'PMKK',
            'Pramuka', 'SSEC'
        ];

        if (!in_array(Auth::user()->role, $allowedRoles)) {
            abort(403, 'Unauthorized');
        }
        return view('layouts.admin.pelatihan.index');
    }
}
