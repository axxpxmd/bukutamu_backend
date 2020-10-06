<?php

namespace App\Http\Controllers\BukuTamu;

use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\BukuTamu;

class BukuTamuController extends Controller
{

    protected $view  = 'pages.bukuTamu.';
    protected $title = 'Buku Tamu';
    protected $route = 'master-data.bukuTamu.';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    public function api()
    {
        $bukuTamu = BukuTamu::all();
        return DataTables::of($bukuTamu)
            ->addColumn('action', function ($p) {
                return "
                <a href='#' onclick='remove(" . $p->id . ")' class='text-danger' title='Hapus Permission'><i class='icon-remove'></i></a>";
            })
            ->editColumn('nama', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->nama . "</a>";
            })
            // ->editColumn('foto',  function ($p) {
            //     if ($p->foto != null) {
            //         return "<img width='50' class='img-fluid mx-auto d-block rounded-circle' alt='foto' src='" . $this->path . $p->foto . "'>";
            //     } else {
            //         return "<img width='50' class='rounded img-fluid mx-auto d-block' alt='foto' src='" . asset('images/404.png') . "'>";
            //     }
            // })
            ->addIndexColumn()
            ->rawColumns(['action', 'nama'])
            ->toJson();
    }
}
