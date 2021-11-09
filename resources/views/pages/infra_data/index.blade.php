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
                        <h1>Manajemen Infrastruktur</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="active"><a href="{{ route('infra_data.index') }}">Infrastruktur</a></li>
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
                        <strong class="card-title">Data Infrasruktur</strong>
                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#createModal">+ Tambah</button>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>Jenis</th>
                                    <th>Merek & Tipe</th>
                                    <th>Fungsi</th>
                                    <th>Serial Number</th>
                                    <th>Lokasi</th>
                                    <th>Masa Aktif Garansi</th>
                                    {{-- <th>Status Garansi</th> --}}
                                    <th>Kondisi</th>
                                    <th>IP</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->


<div class="clearfix"></div>

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="CreateForm" name="CreateForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="row form-group">
                        <input type="hidden" name="id" id="infra_id">
                        <div class="col-6">
                            <label for="type_id" class=" form-control-label">Jenis</label>
                            <select name="type_id" id="type_id" class="form-control">
                                <option value="0">-- Pilih Tipe --</option>
                                @foreach ($types as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="brand" class=" form-control-label">Merek dan Tipe</label>
                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('brand') }}"
                                maxlength="50" required="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-6">
                            <label for="function" class=" form-control-label">Fungsi</label>
                            <input type="text" class="form-control" id="function" name="function"
                                value="{{ old('function') }}" maxlength="50" required="">
                        </div>
                        <div class="col-6">
                            <label for="application" class=" form-control-label">Aplikasi</label>
                            <input type="text" class="form-control" id="application" name="application"
                                value="{{ old('application') }}" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-6">
                            <label for="serialnum" class=" form-control-label">Serial Number</label>
                            <input type="text" class="form-control" id="serialnum" name="serialnum"
                                value="{{ old('serialnum') }}" maxlength="50" required="">
                        </div>
                        <div class="col-6">
                            <label for="location" class=" form-control-label">Lokasi</label>
                            <input type="text" class="form-control" id="location" name="location"
                                value="{{ old('location') }}" maxlength="50" required="">
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-6">
                            <label for="warranty" class=" form-control-label">Masa Aktif Garansi</label>
                            <input type="date" class="form-control" id="warranty" name="warranty"
                                value="{{ old('warranty') }}" maxlength="50" required="">
                        </div>
                        <div class="col-6">
                            <label for="condition" class=" form-control-label">Kondisi</label>
                            <select name="condition" id="condition" class="form-control">
                                <option value="0">-- Pilih Kondisi --</option>
                                <option value="1">Baik</option>
                                <option value="2">Rusak Ringan</option>
                                <option value="3">Rusak Sedang</option>
                                <option value="4">Rusak Berat</option>
                            </select>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-6">
                            <label for="ip" class=" form-control-label">Alamat IP</label>
                            <input type="text" class="form-control" id="ip" name="ip" value="{{ old('ip') }}"
                                maxlength="50" required="">
                        </div>
                        <div class="col-6">
                            <label for="description" class=" form-control-label">Keterangan</label>
                            <textarea name="description" id="description" rows="3" class="form-control"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('after-script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<script type="text/javascript">
    $(function () {
    // alert('12345');
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    var table = $('#bootstrap-data-table').DataTable({
        processing: true,
        //serverSide: false,
        ajax: '{!! route('infra_data.list') !!}',
        columns: [
            {data: 'type_id', name: 'type_id'},
            {data: 'brand', name: 'brand'},
            {data: 'function', name: 'function'},
            {data: 'serialnum', name: 'serialnum'},
            {data: 'location', name: 'location'},
            {data: 'warranty', name: 'warranty'},
            // {data: 'sts_warranty', name: 'sts_warranty'},
            {data: 'condition', name: 'condition'},
            {data: 'ip', name: 'ip'},
            {
                data: 'action', 
                name: 'action', 
                orderable: true, 
                searchable: true
            },
        ]
    });
    
    $('body').on('click', '.editRecord', function () {
      var id = $(this).data('id');
      $.get('infra_data/' + id +'/edit', function (data) {
          $('#smallmodalLabel').html("Edit Data");
          $('#saveBtn').val("edit-data");
          $('#createModal').modal('show');
          $('#infra_id').val(data.id);
          $('#type_id').val(data.type_id);
          $('#brand').val(data.brand);
          $('#function').val(data.function);
          $('#application').val(data.application);
          $('#serialnum').val(data.serialnum);
          $('#location').val(data.location);
          $('#warranty').val(data.warranty);
          $('#condition').val(data.condition);
          $('#ip').val(data.ip);
          $('#description').val(data.description);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
       
        $(this).html('Sending..');
       
        $.ajax({
          data: $('#CreateForm').serialize(),
          url: "{!! route('infra_data.store') !!}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#CreateForm').trigger("reset");
              $('#createModal').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              table.ajax.reload();
              alert(data.success);  
          },
          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('Save Changes');
          }
        });
    });

    $('body').on('click', '.deleteRecord', function () {
        // var token = $("meta[name='csrf-token']").attr("content");
        var id = $(this).data("id");
        confirm("Are You sure want to delete ?");

        $.ajax({
        type: "DELETE",
        url: "infra_data/"+id,
        
        success: function (data) {
            table.ajax.reload();
            alert(data.success);
        },
        error: function (data) {
            alert('Error:', data);
        }
        });
    });

  });
</script>
@endpush