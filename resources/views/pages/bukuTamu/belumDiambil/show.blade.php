@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row">
                <div class="col">
                    <h4>
                        <i class="icon icon-document-cancel2 mr-2"></i>
                        Show {{ $title }} | {{ $bukuTamu->nama }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li>
                        <a class="nav-link" href="{{ route($route.'index') }}"><i class="icon icon-arrow_back"></i>Semua Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content my-3" id="pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="semua-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <h6 class="card-header"><strong>Data Driver</strong></h6>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>ID REgistrasi :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->id_registrasi }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Nama Driver :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->nama }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Jenis Jasa :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->jenis_paket == 1 ? 'Grab' : 'Gojek' }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>No Plat :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->no_plat }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Penerima :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->penerima }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Tanggal :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->tanggal->isoFormat('D MMMM Y') }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Jam :</strong></label>
                                        <label class="col-md-3 s-12">{{ $bukuTamu->jam }}</label>
                                    </div>
                                    <div class="row">
                                        <label class="col-md-2 text-right s-12"><strong>Foto :</strong></label>
                                        <img class="ml-2 m-t-7 rounded-circle" src="{{ config('app.sftp_src').'/ava/'.$bukuTamu->foto }}" width="100" alt="icon">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
