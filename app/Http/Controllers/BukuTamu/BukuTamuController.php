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
        $bukuTamu = BukuTamu::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        return DataTables::of($bukuTamu)
            ->addColumn('action', function ($p) {
                if ($p->status == 0) {
                    return "<a href='#' onclick='remove(" . $p->id . ")' class='text-success' title='Hapus Permission'><i class='icon-check'></i></a>";
                } else {
                    return '-';
                }
            })
            ->editColumn('id_registrasi', function ($p) {
                return "<a href='" . route($this->route . 'show', $p->id) . "' class='text-primary' title='Show Data'>" . $p->id_registrasi . "</a>";
            })
            ->editColumn('jenis_paket', function ($p) {
                if ($p->jenis_paket == 1) {
                    return 'Grab';
                } else {
                    return 'Gojek';
                }
            })
            ->addColumn('waktu', function ($p) {
                return $p->tanggal . '&nbsp;&nbsp;&nbsp; ' . $p->jam;
            })
            ->editColumn('status', function ($p) {
                if ($p->status == 0) {
                    return "Belum Diambil";
                } else {
                    return "Sudah Diambil";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'id_registrasi', 'waktu', 'status'])
            ->toJson();
    }

    public function update(Request $request, $id)
    {
        $bukuTamu = BukuTamu::find($id);
        $bukuTamu->update([
            'status' => 1
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }
}
