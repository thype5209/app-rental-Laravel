<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function index(){
        return Inertia::render('Laporan/LaporanSewa');
    }
}
