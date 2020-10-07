<?php

namespace App\Http\Controllers\BukuTamu;

use PDF;
use DataTables;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\BukuTamu;

class ReportController extends Controller
{
    protected $view  = 'pages.bukuTamu.report.';
    protected $title = 'Report';
    protected $route = 'master-data.report.';

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

        $bukuTamu = BukuTamu::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        if ($request->jenis_jasa != 0) {
            $bukuTamu = BukuTamu::where('jenis_paket', $request->jenis_jasa)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($request->status != 99) {
            $bukuTamu = BukuTamu::where('status', $request->status)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($request->tgl_tinggal) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        } elseif ($request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal1)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        } elseif ($request->tgl_tinggal && $request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereBetween('tanggal', [$request->tgl_tinggal, $request->tgl_tinggal1])->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        return DataTables::of($bukuTamu)
            ->addColumn('action', function ($p) {
                if ($p->status == 0) {
                    return "<a href='#' onclick='remove(" . $p->id . ")' class='text-success' title='Hapus Permission'><i class='icon-check'></i></a>";
                } else {
                    return '-';
                }
            })
            ->editColumn('jenis_paket', function ($p) {
                if ($p->jenis_paket == 1) {
                    return 'Grab';
                } else {
                    return 'Gojek';
                }
            })
            ->addColumn('waktu', function ($p) {
                return $p->tanggal . '&nbsp;&nbsp;' . $p->jam;
            })
            ->editColumn('status', function ($p) {
                if ($p->status == 0) {
                    return "Belum Diambil";
                } else {
                    return "Sudah Diambil";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'waktu', 'status'])
            ->toJson();
    }

    public function print(Request $request)
    {
        if ($request->jenis_jasa != 0) {
            $bukuTamu = BukuTamu::where('jenis_paket', $request->jenis_jasa)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($request->status != 99) {
            $bukuTamu = BukuTamu::where('status', $request->status)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($request->tgl_tinggal) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        } elseif ($request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal1)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        } elseif ($request->tgl_tinggal && $request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereBetween('tanggal', [$request->tgl_tinggal, $request->tgl_tinggal1])->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        $pdf = PDF::loadview($this->view . 'report', compact('bukuTamu'))->setPaper('a4', 'portrait');
        return $pdf->download('report');

        // return view($this->view . 'report', compact('bukuTamu'));
    }
}
