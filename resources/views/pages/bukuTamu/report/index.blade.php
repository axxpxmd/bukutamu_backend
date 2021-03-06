@extends('layouts.app')
@section('title', '| '.$title.'')
@section('content')
<div class="page has-sidebar-left height-full">
    <header class="blue accent-3 relative nav-sticky">
        <div class="container-fluid text-white">
            <div class="row p-t-b-10 ">
                <div class="col">
                    <h4>
                        <i class="icon icon-report mr-2"></i>
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
    <form  action="{{ route('master-data.cetak') }}" method="POST" >
        @csrf
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
                                <label for="status" class="col-form-label s-12 col-md-3 text-right"><strong>Status :</strong></label>
                                <div class="col-sm-4">
                                    <select name="status" id="status" class="select2 form-control r-0 light s-12" onchange="selectOnChange()">
                                        <option value="99">Semua</option>
                                        <option value="1">Sudah diambil</option>
                                        <option value="0">Belum diambil</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="form-group row" style="margin-top: -10px">
                                <label for="tujuan" class="col-form-label s-12 col-md-3 text-right"><strong>Tujuan :</strong></label>
                                <div class="col-sm-4">
                                    <select name="tujuan" id="tujuan" class="select2 form-control r-0 light s-12" onchange="selectOnChange()">
                                        <option value="0">Semua</option>
                                        <option value="1">Mengambil</option>
                                        <option value="2">Mengirim</option>
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
                            {{-- <div class="form-group row" style="margin-top: -10px">
                                <label for="tanggal" class="col-form-label s-12 col-md-3 text-right"><strong>Cetak Report :</strong></label>
                                <div class="col-sm-4 row">
                                    <button class="btn btn-primary s-12" style="margin-left:3%">Save as PDF</button>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                                            <th width="100">ID Registrasi</th>
                                            <th width="120">Nama Driver</th>
                                            <th width="70">Jenis Jasa</th>
                                            <th width="80">Plat Nomor</th>
                                            <th width="100">No Driver</th>
                                            <th width="120">Petugas</th>
                                            <th width="120">Pemesan</th>
                                            {{-- <th width="100">No Pemesan</th> --}}
                                            <th width="200">Waktu</th>
                                            <th width="80">Tujuan</th>
                                            <th width="100">Status</th>
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
<script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/colreorder/1.5.2/js/dataTables.colReorder.min.js"></script>
<script type="text/javascript">
    var table = $('#dataTable').dataTable({
        dom: 'Blfrtip',
        buttons: [
            'csv',
            {
                extend: 'pdfHtml5',
                orientation: 'landscape',
                pageSize: 'LEGAL'
            },
            'copy',
            'print'
        ],
        lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
        processing: true,
        serverSide: true,
        order: [ 0, 'asc' ],
        pageLength : 15,
        ajax: {
            url: "{{ route($route.'api') }}",
            method: 'POST',
            data: function (data) {
                data.jenis_jasa = $('#jenis_jasa').val();
                data.status = $('#status').val();
                data.tgl_tinggal = $('#tgl_tinggal').val();
                data.tgl_tinggal1 = $('#tgl_tinggal1').val();
                data.tujuan = $('#tujuan').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, align: 'center', className: 'text-center'},
            {data: 'id_registrasi', name: 'id_registrasi'},
            {data: 'nama', name: 'nama'},
            {data: 'jenis_paket', name: 'jenis_paket'},
            {data: 'no_plat', name: 'no_plat'},
            {data: 'no_telp', name: 'no_telp'},
            {data: 'penerima', name: 'penerima'},
            {data: 'pemesan', name: 'pemesan'},
            // {data: 'no_telp_pemesan', name: 'no_telp_pemesan'},
            {data: 'waktu', name: 'waktu'},
            {data: 'tujuan', name: 'tujuan'},
            {data: 'status', name: 'status', className: 'text-center'},
        ]
    });

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
