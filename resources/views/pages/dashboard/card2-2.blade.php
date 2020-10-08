<div class="col-md-4">
    <div class="white">
        <div class="card">
            <div class="card-header bg-primary text-white b-b-light">
                <div class="row justify-content-end">
                    <div class="col">
                        <ul id="myTab4" role="tablist" class="nav nav-tabs card-header-tabs nav-material nav-material-white float-right">
                            <li class="nav-item">
                                <a class="nav-link active show" id="tab1" data-toggle="tab" href="#v-pills-tab1" role="tab" aria-controls="tab1" aria-expanded="true" aria-selected="true">Hari Ini</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-body no-p">
                <div class="tab-content">
                    <div class="tab-pane animated fadeIn show active" id="v-pills-tab1" role="tabpanel" aria-labelledby="v-pills-tab1">
                        <div class="bg-primary text-white lighten-2">
                            <div class="pt-5 pb-2 pl-5 pr-5">
                                {{-- <h5 class="font-weight-normal s-14"></h5> --}}
                                <span class="s-48 font-weight-lighter text-primary">
                                    {{ $today }}
                                </span>
                                <div class="float-right">
                                    <span class="icon icon-arrow_downward s-48"></span>
                                    <span class="icon icon-arrow_upward s-48"></span>
                                </div>
                            </div>
                            <canvas width="378" 
                                    height="30" 
                                    data-chart="spark"     
                                    data-chart-type="line"
                                    data-dataset="[[28,530,200,430]]" 
                                    data-labels="['a','b','c','d']"
                                    data-dataset-options="[{ borderColor:  'rgba(54, 162, 235, 1)', backgroundColor: 'rgba(54, 162, 235,1)' }]">
                            </canvas>
                        </div>
                        <div class="slimScroll b-b" data-height="150">
                            <div class="table-responsive">
                                <table class="table table-hover earning-box">
                                    <thead class="no-b">
                                        <tr>
                                            <th colspan="2"></th>
                                            <th>Proses</th>
                                            <th>Selesai</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="w-10">
                                                <a href="panel-page-profile.html">
                                                    <img class="mt-2" src="{{ asset('images/logo/gojek.png') }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <h6 class="mt-2">Gojek</h6>
                                                {{-- <small class="text-muted">Marketing Manager</small> --}}
                                            </td>
                                            <td>{{ $gojekproses }}</td>
                                            <td>{{ $gojekselesai }}</td>
                                        </tr>
                                        <tr>
                                            <td class="w-10">
                                                <a href="panel-page-profile.html">
                                                    <img class="mt-2" src="{{ asset('images/logo/grab.jpg') }}" alt="">
                                                </a>
                                            </td>
                                            <td>
                                                <h6 class="mt-2">Grab</h6>
                                                {{-- <small class="text-muted">Marketing Manager</small> --}}
                                            </td>
                                            <td>{{ $grabproses }}</td>
                                            <td>{{ $grabselesai }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>