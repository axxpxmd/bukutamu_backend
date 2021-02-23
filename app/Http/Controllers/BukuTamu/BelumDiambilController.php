<?php

namespace App\Http\Controllers\BukuTamu;

use DataTables;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\BukuTamu;

class BelumDiambilController extends Controller
{
    protected $view  = 'pages.bukuTamu.belumDiambil.';
    protected $title = 'Belum Diambil';
    protected $route = 'master-data.belum-diambil.';

    public function index()
    {
        $route = $this->route;
        $title = $this->title;

        return view($this->view . 'index', compact(
            'route',
            'title'
        ));
    }

    public function api(Request $request)
    {
        $time    = Carbon::now();
        $tanggal = $time->toDateString();

        $select = [
            'id', 'id_registrasi', 'nama', 'jenis_paket', 'no_plat', 'no_telp', 'penerima', 'pemesan', 'tanggal', 'jam', 'tujuan', 'status'
        ];

        $bukuTamu = BukuTamu::select($select)
            ->where('status', 0)
            ->whereDate('tanggal', $tanggal)
            ->orderBy('status', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();

        $jenis_jasa   = $request->jenis_jasa;
        $tgl_tinggal  = $request->tgl_tinggal;
        $tgl_tinggal1 = $request->tgl_tinggal1;

        if ($jenis_jasa != 0) {
            $bukuTamu = BukuTamu::select($select)
                ->where('jenis_paket', $jenis_jasa)
                ->where('status', 0)
                ->whereDate('tanggal', $tanggal)
                ->orderBy('status', 'ASC')
                ->orderBy('id', 'DESC')->get();
        }

        if ($tgl_tinggal != null) {
            $bukuTamu = BukuTamu::select($select)
                ->whereDate('tanggal', $tgl_tinggal)
                ->where('status', 0)
                ->orderBy('status', 'ASC')
                ->orderBy('id', 'DESC')->get();
            if ($jenis_jasa != 0) {
                $bukuTamu = BukuTamu::select($select)
                    ->where('jenis_paket', $jenis_jasa)
                    ->whereDate('tanggal', $tgl_tinggal)
                    ->where('status', 0)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

        if ($tgl_tinggal && $tgl_tinggal1 != null) {
            $bukuTamu = BukuTamu::select($select)
                ->whereBetween('tanggal', [$tgl_tinggal, $tgl_tinggal1])
                ->where('status', 0)
                ->orderBy('status', 'ASC')
                ->orderBy('id', 'DESC')->get();
            if ($jenis_jasa != 0) {
                $bukuTamu = BukuTamu::selct($select)
                    ->where('jenis_paket', $jenis_jasa)
                    ->whereBetween('tanggal', [$tgl_tinggal, $tgl_tinggal1])
                    ->where('status', 0)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

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
            ->editColumn('tujuan', function ($p) {
                if ($p->tujuan == 1) {
                    return 'Mengambil';
                } else {
                    return 'Mengirim';
                }
            })
            ->editColumn('no_plat', function ($p) {
                return "<span class='text-uppercase'>" . $p->no_plat . "</span>";
            })
            ->addColumn('waktu', function ($p) {
                $tanggal = Carbon::parse($p->tanggal)->isoFormat('D-MMM-Y');
                return $tanggal . '&nbsp;&nbsp;' . $p->jam;
            })
            ->editColumn('status', function ($p) {
                if ($p->status == 0) {
                    return "<span class='bg-danger text-white p-1 rounded fs-12'>Belum Diambil</span>";
                } else {
                    return "Sudah Diambil";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'id_registrasi', 'waktu', 'status', 'no_plat'])
            ->toJson();
    }

    public function update($id)
    {
        $bukuTamu = BukuTamu::find($id);
        $bukuTamu->update([
            'status' => 1
        ]);

        return response()->json([
            'message' => 'Data ' . $this->title . ' berhasil diperbaharui.'
        ]);
    }

    public function show($id)
    {
        $route = $this->route;
        $title = $this->title;

        $bukuTamu = BukuTamu::find($id);

        return view($this->view . 'show', compact(
            'route',
            'title',
            'bukuTamu'
        ));
    }
}
