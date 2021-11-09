@push('after-style')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<link href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endpush
@extends('layouts.default')

@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Laporan Garansi</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="active"><a href="#">Laporan Garansi</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">LAPORAN GARANSI</strong>
                        <a class="btn btn-info btn-sm float-right" href="{{ route('infra_data.export_garansi') }}" target="_blank">Export</a>
                    </div>
                    <div class="card-body">
                        <h4 class="text-center mb-3">Data Infrastruktur Yang Telah Habis Masa Garansinya</h4>
                        <table id="bootstrap-data-table" class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Merek & Tipe</th>
                                    <th>Fungsi</th>
                                    <th>Serial Number</th>
                                    <th>Masa Aktif Garansi</th>
                                    <th>Kondisi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1;?>
                                @forelse ($items as $item)
                                
                                <tr>
                                    <td>{{$no++}}</td>
                                    <td>{{$item->brand}}</td>
                                    <td>{{$item->function}}</td>
                                    <td>{{$item->serialnum}}</td>
                                    <td>{{$item->warranty}}</td>
                                    <td>
                                        @if ($item->condition == 1)
                                        <span class="badge badge-primary">Baik</span>
                                        @elseif ($item->condition == 2)
                                        <span class="badge badge-secondary">Rusak Ringan</span>
                                        @elseif ($item->condition == 3)
                                        <span class="badge badge-warning">Rusak Sedang</span>
                                        @elseif ($item->condition == 4)
                                        <span class="badge badge-danger">Rusak Berat</span>
                                        @else
                                        -
                                        @endif
                                    </td>
                                <td>Expired</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-secondary" role="alert">
                                            Data Tidak Ditemukan!
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <h4 class="text-center mb-3">Data Infrastruktur Yang Akan Habis Masa Garansinya</h4>
                        <table id="bootstrap-data-table" class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Merek & Tipe</th>
                                    <th>Fungsi</th>
                                    <th>Serial Number</th>
                                    <th>Masa Aktif Garansi</th>
                                    <th>Kondisi</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;?>
                                @forelse ($items_exp as $item)
                                
                                <tr>
                                    <td>{{$i++}}</td>
                                    <td>{{$item->brand}}</td>
                                    <td>{{$item->function}}</td>
                                    <td>{{$item->serialnum}}</td>
                                    <td>{{$item->warranty}}</td>
                                    <td>
                                        @if ($item->condition == 1)
                                        <span class="badge badge-primary">Baik</span>
                                        @elseif ($item->condition == 2)
                                        <span class="badge badge-secondary">Rusak Ringan</span>
                                        @elseif ($item->condition == 3)
                                        <span class="badge badge-warning">Rusak Sedang</span>
                                        @elseif ($item->condition == 4)
                                        <span class="badge badge-danger">Rusak Berat</span>
                                        @else
                                        -
                                        @endif
                                    </td>
                                <td>Aktif</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="alert alert-secondary" role="alert">
                                            Data Tidak Ditemukan!
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->


<div class="clearfix"></div>


@endsection