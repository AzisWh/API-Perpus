<?php

namespace App\Http\Controllers\View\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardPetugas extends Controller
{
    public function index()
    {
        return view("petugas.index");
    }
}
