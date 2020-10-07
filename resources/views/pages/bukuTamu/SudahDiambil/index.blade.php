@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon icon-document-checked2 mr-2"></i>
                        List {{ $title }}
                    </h4>
                </div>
            </div>
            <div class="row justify-content-between">
                <ul role="tablist" class="nav nav-material nav-material-white responsive-tab">
                    <li class="nav-item">
                        <a class="nav-link active show" id="tab1" data-toggle="tab" href="#semua-data" role="tab"><i class="icon icon-home2"></i>Semua Data</a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card no-b">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="jenis_jasa" class="col-form-label s-12 col-md-3 text-right"><strong>Jenis Jasa :</strong></label>
                            <div class="col-sm-4">
                                <select name="jenis_jasa" id="jenis_jasa" class="select2 form-control r-0 light s-12" onchange="selectOnChange()">
                                    <option value="0">Semua</option>
                                    <option value="1">Grab</option>
                                    <option value="2">Gojek</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group row" style="margin-top: -10px">
                            <label for="tanggal" class="col-form-label s-12 col-md-3 text-right"><strong>Tanggal :</strong></label>
                            <div class="col-sm-4 row">
                                <input type="text" name="tgl_tinggal" id="tgl_tinggal" placeholder="" class="form-control r-0 light s-12 col-md-4 ml-3" autocomplete="off" onchange="selectOnChange()"/>
                                <span class="mt-1 ml-2 mr-2">-</span>
                                <input type="text" name="tgl_tinggal1" id="tgl_tinggal1" placeholder="" class="form-control r-0 light s-12 col-md-4" autocomplete="off" onchange="selectOnChange()"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid relative animatedParent animateOnce">
        <div class="tab-content my-3" id="pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="semua-data" role="tabpanel">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card no-b">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-striped table-bordered" style="width:100%">
                                        <thead>
                                            <th width="30">No</th>
                                            <th>ID Registrasi</th>
                                            <th>Nama Driver</th>
                                            <th>Jenis Jasa</th>
                                            <th>Plat Nomor</th>
                                            <th>Penerima</th>
                                            <th width="200">Waktu</th>
                                            <th width="100">Status</th>
                                            <th>Aksi</th>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
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
@section('script')
<script type="text/javascript">
    var table = $('#dataTable').dataTable({
        processing: true,
        serverSide: true,
        order: [ 0, 'asc' ],
        pageLength : 15,
        ajax: {
            url: "{{ route($route.'api') }}",
            method: 'POST',
            data: function (data) {
                data.jenis_jasa = $('#jenis_jasa').val();
                data.tgl_tinggal = $('#tgl_tinggal').val();
                data.tgl_tinggal1 = $('#tgl_tinggal1').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'id_registrasi', name: 'id_registrasi'},
            {data: 'nama', name: 'nama'},
            {data: 'jenis_paket', name: 'jenis_paket'},
            {data: 'no_plat', name: 'no_plat'},
            {data: 'penerima', name: 'penerima'},
            {data: 'waktu', name: 'waktu'},
            {data: 'status', name: 'status', className: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center'}
        ]
    });

    setInterval(function(){ 
        table.api().ajax.reload();
    }, 5000);

    function selectOnChange(){
        table.api().ajax.reload();
    }

    $('#tgl_tinggal').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){},
        timepicker:false
    });

    
    $('#tgl_tinggal1').datetimepicker({
        format:'Y-m-d',
        onShow:function( ct ){},
        timepicker:false
    });


    function remove(id){
        $.confirm({
            title: '',
            content: 'Apakah Driver Sudah Mengambil Paket ?',
            icon: 'icon icon-question amber-text',
            theme: 'modern',
            closeIcon: true,
            animation: 'scale',
            type: 'green',
            buttons: {
                ok: {
                    text: "Sudah",
                    btnClass: 'btn-primary',
                    keys: ['enter'],
                    action: function(){
                        $.post("{{ route($route.'update', ':id') }}".replace(':id', id), {'_method' : 'PATCH'}, function(data) {
                           table.api().ajax.reload();
                            if(id == $('#id').val()) add();
                        }, "JSON").fail(function(){
                            reload();
                        });
                    }
                },
                cancel: function(){}
            }
        });
    }

</script>
@endsection
