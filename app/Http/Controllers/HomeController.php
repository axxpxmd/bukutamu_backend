<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of welcome
 *
 * @author Asip Hamdi
 * Github : axxpxmd
 */

namespace App\Http\Controllers;

use App\Models\BukuTamu;
use Carbon\Carbon;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $gojek = BukuTamu::where('jenis_paket', 2)->count();

        $grab = BukuTamu::where('jenis_paket', 1)->count();
        $check = Carbon::now();

        $time    = Carbon::now();
        $tanggal = $time->toDateString();

        $today = BukuTamu::whereDate('tanggal', $tanggal)->count();

        return view('home', compact('gojek', 'grab', 'today'));
    }
}
