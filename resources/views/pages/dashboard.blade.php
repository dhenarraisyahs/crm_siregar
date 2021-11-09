@extends('layouts.default')
@push('before-style')
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
@endpush
@section('content')
<div class="content">
    <!-- Animated -->
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $pass_warranty }}</h2>
                                    </div>
                                    <div class="stat-heading">Telah Lewat Masa Garansi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $pass_warranty_this_year }}</h2>
                                    </div>
                                    <div class="stat-heading">Lewat Masa Garansi Tahun Ini</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $infra_baik }}</h2>
                                    </div>
                                    <div class="stat-heading">Infrastruktur Kondisi Baik</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $rusak_ringan }}</h2>
                                    </div>
                                    <div class="stat-heading">Infrastruktur Rusak Ringan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $rusak_sedang }}</h2>
                                    </div>
                                    <div class="stat-heading">Infrastruktur Rusak Sedang</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-content">
                                <div class="dib">
                                    <div class="stat-text">
                                        <h2 class="count">{{ $rusak_berat }}</h2>
                                    </div>
                                    <div class="stat-heading">Infrastruktur Rusak Berat</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Widgets -->
        <!--  /Traffic -->
        <div class="clearfix"></div>
        <!-- Orders -->
        <div class="orders">
            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <span class="box-title">Log Notifikasi </span>
                            <a class="btn btn-success btn-sm float-right" href="{{route('infra_data.create')}}">Selengkapnya</a>
                        </div>
                        <div class="card-body--">
                            <div class="table-stats order-table ov-h">
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th class="serial">#</th>
                                            <th>Notifikasi</th>
                                        </tr>
                                    </thead>
                                    <tbody >
                                        <?php 
                                            $no=1;
                                            // $today = date("Y-m-d", strtotime(now()));    
                                        ?>
                                        @forelse ($notifs as $notif)
                                            {{-- @if (date($notif->warranty, strtotime("-30 days")) >= $today) --}}
                                            <tr>
                                                <td class="serial">{{$no++}}</td>
                                                <td class="text-left"> Infrastruktur {{$notif->InfraType->type_name}} dengan Serial Number {{$notif->serialnum}} akan habis masa garansinya pada tanggal {{ date("d M Y", strtotime( $notif->warranty )) }}.
                                                </td>
                                            {{-- @endif --}}
                                        </tr>
                                        @empty
                                            
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                            </div> <!-- /.table-stats -->
                        </div>
                    </div> <!-- /.card -->
                </div>
                <div class="col-xl-6">
                    <div class="row">
                        <div class="col-lg-6 col-xl-12">
                            <div class="card">
                                {{-- <div class="card-body"> --}}
                                    <div class="flot-container">
                                        <div id="flot-pie" class="flot-pie-container"></div>
                                    </div>
                                {{-- </div> --}}
                            </div>
                        </div>
                    </div>
                </div> <!-- /.col-lg-8 -->
            </div>
        </div>
        <!-- /.orders -->
        <!-- /#add-category -->
    </div>
    <!-- .animated -->
</div>
@endsection
@push('after-script')

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
            // alert("test");
            Highcharts.chart('flot-pie', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Data Infrastruktur'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.y:.0f}</b>'
                },
                accessibility: {
                    point: {
                        valueSuffix: '%'
                    }
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                        }
                    }
                },
                series: [{
                    name: 'Jumlah',
                    colorByPoint: true,
                    data: <?= $data ?>
                }]
            });
        });
    </script>
@endpush
