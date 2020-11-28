@extends('adminlte::page')

@section('title', 'Brand')

@section('content_header')
    <h1>Brand</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-4">
                <div class="card card-primary card-outline" id="brand_form_create">
                    <div class="card-header">
                        <div class="card-title">Buat Brand baru</div>
                    </div>
                    <form id="brand_form_create" action="{{ route('brand.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand_name" placeholder="Nama Brand" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card card-primary card-outline" id="brand_form_edit" style="display: none">
                    <div class="card-header">
                        <div class="card-title">Edit Brand</div>
                    </div>
                    <form id="brand_form_edit" action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="brand">Brand</label>
                                <input type="text" name="brand_name" placeholder="Nama Brand" class="form-control">
                                <input type="hidden" name="brand_id" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="reset" class="cancel-button btn btn-danger btn-sm">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-8">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            Daftar Brand yang terdaftar
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="brand_table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
    <script>
        $(function(){
            // Datatable
            $('#brand_table').DataTable({
                processing: true,
                serverside: true,
                ajax: {
                    url: "{{ route('brand.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'id brand',
                    },
                    {
                        data: 'name',
                        name: 'nama brand',
                    },
                    {
                        data: 'action',
                        name: 'action',
                    },
                ]
            });
        });

        // AJAX INPUT BRAND BARU
        $('form#brand_form_create').on('submit', function(e){
            e.preventDefault();
            $.ajax({
               url: $(this).attr('action'),
               method: 'post',
               data: $(this).serialize(),
               success: function (data) {
                   if(data.success){
                       Swal.fire('Berhasil!', data.success, 'success');
                       $('form#brand_form_create')[0].reset();
                       $('#brand_table').DataTable().ajax.reload();
                   }
               }
            });
        });

        // AJAX DELETE BRAND BY ID
        $('#brand_table').on('click', '.delete-brand', function(){
            var brand_id = $(this).data('id');
            Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/brand/delete/'+brand_id,
                        success: function(data){
                            if(data.success){
                                Swal.fire('Deleted!',data.success,'success');
                                $('#brand_table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });
        });

        $('#brand_table').on('click', '.edit-brand', function(){
            var brand_id = $(this).data('id');
            $.ajax({
                url: '/brand/detail/'+brand_id,
                method: 'get',
                success: function(data){
                    $('#brand_form_create').hide();
                    $('#brand_form_edit').show();
                    $('input[name="brand_name"]').val(data.name);
                    $('input[name="brand_id"]').val(data.id);
                }
            });
        });

        $('.cancel-button').on('click', function(){
            $('#brand_form_create').show();
            $('form#brand_form_create')[0].reset();
            $('form#brand_form_edit')[0].reset();
            $('#brand_form_edit').hide();
        });

        $('form#brand_form_edit').on('submit', function(e){
            e.preventDefault();
            var brand_id = $('input[name="brand_id"]').val();
            $.ajax({
                url: '/brand/edit/'+brand_id,
                data: $(this).serialize(),
                method: 'post',
                success: function(data){
                    if(data.success){
                        Swal.fire('Berhasil!', data.success, 'success');
                        $('#brand_form_create').show();
                        $('form#brand_form_create')[0].reset();
                        $('form#brand_form_edit')[0].reset();
                        $('#brand_form_edit').hide();
                        $('#brand_table').DataTable().ajax.reload();
                    }
                }
            })
        });
    </script>
@stop