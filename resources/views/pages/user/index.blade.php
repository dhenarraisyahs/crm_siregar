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
                        <h1>Manajemen User</h1>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
                <div class="page-header float-right">
                    <div class="page-title">
                        <ol class="breadcrumb text-right">
                            <li><a href="{{ route('home') }}">Dashboard</a></li>
                            <li class="active"><a href="{{ route('user.index') }}">User</a></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($message = Session::get('success'))
<div class="alert alert-success">
    <p id="msg">{{ $message }}</p>
</div>
@endif
<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong class="card-title">Data User</strong>
                        <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                            data-target="#createModal">+ Tambah</button>
                    </div>
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-bordered yajra-datatable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
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

<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="smallmodalLabel">Form Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="CustomerForm" name="CustomerForm" class="form-horizontal">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" name="id" id="user_id">
                        <label for="name" class=" form-control-label">Name</label>
                        {{-- <input type="text" id="name" class="form-control" value="{{ old('name') }}"> --}}
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}"
                            maxlength="50" required="">
                    </div>
                    <div class="form-group">
                        <label for="email" class=" form-control-label">Email</label>
                        {{-- <input type="email" id="email" class="form-control" value="{{ old('email') }}"> --}}
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                            required="">
                    </div>
                    <div class="form-group">
                        <label for="role" class=" form-control-label">Role</label>
                        <select name="role" id="role" class="form-control">
                            <option value="0">-- Pilih Role --</option>
                            <option value="1">Admin</option>
                            <option value="2">User</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="password" class=" form-control-label">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                            value="{{ old('password') }}">
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
        ajax: '{!! route('user.list') !!}',
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'role', name: 'role'},
            {
                data: 'action', 
                name: 'action', 
                // orderable: true, 
                // searchable: true
            },
        ]
    });

    $('body').on('click', '.editRecord', function () {
      var id = $(this).data('id');
      $.get('user/' + id +'/edit', function (data) {
          $('#smallmodalLabel').html("Edit Data");
          $('#saveBtn').val("edit-data");
          $('#createModal').modal('show');
          $('#user_id').val(data.id);
          $('#name').val(data.name);
          $('#email').val(data.email);
          $('#role').val(data.role);
          $('#password').val(data.password);
      })
   });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#CustomerForm').serialize(),
          url: '{!! route('user.store') !!}',
          type: "POST",
          dataType: 'json',
          success: function (data) {
              $('#CustomerForm').trigger("reset");
              $('#createModal').modal('hide');
              $('body').removeClass('modal-open');
              $('.modal-backdrop').remove();
              table.ajax.reload();
              alert(data.success);
            //   $('#mediumBody').html(result).show();  
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
        url: "user/"+id,
        
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