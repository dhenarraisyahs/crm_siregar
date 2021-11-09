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
                        <h1>Laporan Keseluruhan</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="active"><a href="#">Laporan Keseluruhan</a></li>
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
                        <strong class="card-title">LAPORAN KESELURUHAN</strong>
                        <a class="btn btn-info btn-sm float-right" href="{{ route('infra_data.export_report') }}" target="_blank">Export</a>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jenis</th>
                                    <th>Merek & Tipe</th>
                                    <th>Fungsi</th>
                                    <th>Serial Number</th>
                                    <th>Lokasi</th>
                                    <th>Alamat IP</th>
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
                                    <td>{{$item->InfraType->type_name}}</td>
                                    <td>{{$item->brand}}</td>
                                    <td>{{$item->function}}</td>
                                    <td>{{$item->serialnum}}</td>
                                    <td>{{$item->location}}</td>
                                    <td>{{$item->ip}}</td>
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
                                    <td>
                                        @if ($item->warranty <= date("Y-m-d", strtotime(now())) )
                                            Expired
                                        @else
                                            Aktif
                                        @endif
                                    </td>
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