<?php

namespace App\Http\Controllers\BukuTamu;

use PDF;
use DataTables;

use Carbon\Carbon;
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

        $jenis_jasa = $request->jenis_jasa;
        $status     = $request->status;
        $tujuan     = $request->tujuan;
        $tgl_tinggal  = $request->tgl_tinggal;
        $tgl_tinggal1 = $request->tgl_tinggal1;

        if ($jenis_jasa != 0) {
            $bukuTamu = BukuTamu::where('jenis_paket', $jenis_jasa)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($status != 99) {
            $bukuTamu = BukuTamu::where('status', $status)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $request->status)
                    ->where('jenis_paket', $jenis_jasa)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

        if ($tujuan != 0) {
            $bukuTamu = BukuTamu::where('tujuan', $tujuan)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($tujuan != 99 && $jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $status)
                    ->where('jenis_paket', $jenis_jasa)
                    ->where('tujuan', $tujuan)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

        if ($tgl_tinggal != null) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($status != 99 && $jenis_jasa != 0 && $tujuan != 0) {
                $bukuTamu = BukuTamu::where('status', $status)
                    ->where('jenis_paket', $jenis_jasa)
                    ->where('tujuan', $tujuan)
                    ->whereDate('tanggal', $tgl_tinggal)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

        if ($tgl_tinggal && $tgl_tinggal1 != null) {
            $bukuTamu = BukuTamu::whereBetween('tanggal', [$request->tgl_tinggal, $request->tgl_tinggal1])->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($status != 99 && $jenis_jasa != 0 && $tujuan != 0) {
                $bukuTamu = BukuTamu::where('status', $status)
                    ->where('jenis_paket', $jenis_jasa)
                    ->where('tujuan', $tujuan)
                    ->whereDate('tanggal', $tgl_tinggal)
                    ->orderBy('status', 'ASC')
                    ->orderBy('id', 'DESC')->get();
            }
        }

        return DataTables::of($bukuTamu)
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
            ->addColumn('waktu', function ($p) {
                $tanggal = Carbon::parse($p->tanggal)->isoFormat('D-MMM-Y');
                return $tanggal . '&nbsp;&nbsp;' . $p->jam;
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
        $bukuTamu = BukuTamu::orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

        if ($request->jenis_jasa != 0) {
            $bukuTamu = BukuTamu::where('jenis_paket', $request->jenis_jasa)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
        }

        if ($request->status != 99) {
            $bukuTamu = BukuTamu::where('status', $request->status)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

            if ($request->jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $request->status)->where('jenis_paket', $request->jenis_jasa)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            }
        }

        if ($request->tgl_tinggal) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($request->status != 99 && $request->jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $request->status)->where('jenis_paket', $request->jenis_jasa)->whereDate('tanggal', $request->tgl_tinggal)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            }
        } elseif ($request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereDate('tanggal', $request->tgl_tinggal1)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            if ($request->status != 99 && $request->jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $request->status)->where('jenis_paket', $request->jenis_jasa)->whereDate('tanggal', $request->tgl_tinggal1)->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            }
        } elseif ($request->tgl_tinggal && $request->tgl_tinggal1) {
            $bukuTamu = BukuTamu::whereBetween('tanggal', [$request->tgl_tinggal, $request->tgl_tinggal1])->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();

            if ($request->status != 99 && $request->jenis_jasa != 0) {
                $bukuTamu = BukuTamu::where('status', $request->status)->where('jenis_paket', $request->jenis_jasa)->whereBetween('tanggal', [$request->tgl_tinggal, $request->tgl_tinggal1])->orderBy('status', 'ASC')->orderBy('id', 'DESC')->get();
            }
        }

        $pdf = PDF::loadview($this->view . 'report', compact('bukuTamu'))->setPaper('a4', 'portrait');
        return $pdf->download('report');

        // return view($this->view . 'report', compact('bukuTamu'));
    }
}
