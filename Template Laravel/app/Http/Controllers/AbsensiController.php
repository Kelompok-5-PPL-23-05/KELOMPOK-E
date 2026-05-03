<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index() 
    { 
        return view('absensi.index'); 
    }
    
    public function store(Request $request) 
    { 
        return back(); 
    }
    
    public function rekap() 
    { 
        return view('absensi.rekap'); 
    }
}