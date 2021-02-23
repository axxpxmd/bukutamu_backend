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
        $time    = Carbon::now();
        $tanggal = $time->toDateString();

        $select = [
            'id', 'id_registrasi', 'nama', 'jenis_paket', 'no_plat', 'no_telp', 'penerima', 'pemesan', 'tanggal', 'jam', 'tujuan', 'status'
        ];

        $bukuTamu = BukuTamu::select($select)
            ->whereDate('tanggal', $tanggal)
            ->orderBy('status', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();

        $jenis_jasa = $request->jenis_jasa;
        $status     = $request->status;
        $tujuan     = $request->tujuan;
        $tgl_tinggal  = $request->tgl_tinggal;
        $tgl_tinggal1 = $request->tgl_tinggal1;

        if ($jenis_jasa != 0) {
            $bukuTamu = BukuTamu::select($select)
                ->whereDate('tanggal', $tanggal)->where('jenis_paket', $jenis_jasa)
                ->orderBy('status', 'ASC')->orderBy('id', 'DESC')
                ->get();
        }

        if ($status != 99) {
            $bukuTamu = BukuTamu::select($select)
                ->whereDate('tanggal', $tanggal)->where('status', $status)
                ->orderBy('status', 'ASC')->orderBy('id', 'DESC')
                ->get();
            if ($jenis_jasa != 0) {
                $bukuTamu = BukuTamu::select($select)
                    ->whereDate('tanggal', $tanggal)->where('status', $request->status)->where('jenis_paket', $jenis_jasa)
                    ->orderBy('status', 'ASC')->orderBy('id', 'DESC')
                    ->get();
            }
        }

        if ($tujuan != 0) {
            $bukuTamu = BukuTamu::select($select)
                ->whereDate('tanggal', $tanggal)->where('tujuan', $tujuan)
                ->orderBy('status', 'ASC')->orderBy('id', 'DESC')
                ->get();
            if ($tujuan != 99 && $jenis_jasa != 0) {
                $bukuTamu = BukuTamu::select($select)
                    ->whereDate('tanggal', $tanggal)->where('status', $status)->where('jenis_paket', $jenis_jasa)->where('tujuan', $tujuan)
                    ->orderBy('status', 'ASC')->orderBy('id', 'DESC')
                    ->get();
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
                    return "<span class='bg-success text-white p-1 rounded fs-12'>Sudah Diambil</span>";
                }
            })
            ->addIndexColumn()
            ->rawColumns(['action', 'waktu', 'status', 'no_plat'])
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
