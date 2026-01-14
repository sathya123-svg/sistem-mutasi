<?php

namespace App\Http\Controllers;

use App\Models\Banjar;
use Illuminate\Http\Request;

class BanjarController extends Controller
{
    public function index()
    {
        $banjar = Banjar::orderBy('nama')->get();

        return view('banjar.index', compact('banjar'));
    }
}

