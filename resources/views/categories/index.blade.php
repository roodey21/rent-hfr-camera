@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-4">
                <div class="card card-primary card-outline" id="category_create">
                    <div class="card-header">
                        <div class="card-title">Buat Category baru</div>
                    </div>
                    <form id="category_form_create" action="{{ route('category.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_name">Nama</label>
                                <input type="text" name="category_name" placeholder="Nama Kategori" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="category_parent_id">Pilih Induk</label>
                                <select type="text" name="category_parent_id" class="select2 form-control" style="width: 100%">
                                    
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="card card-primary card-outline" id="category_edit" style="display: none">
                    <div class="card-header">
                        <div class="card-title">Edit Kategori</div>
                    </div>
                    <form id="category_form_edit" action="#" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category_name">Nama</label>
                                <input type="text" name="category_name" placeholder="Nama Kategori" class="form-control">
                                <input type="hidden" name="category_id" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="category_parent_id">Pilih Induk</label>
                                <select type="text" name="category_parent_id" class="select2 select2edit form-control" style="width: 100%">
                                </select>
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
                            Daftar Semua Kategori
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="category_table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Induk Kategori</th>
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
            // DATATABLE
            $('#category_table').DataTable({
                processing: true,
                serverside: true,
                ajax: {
                    url: "{{ route('category.index') }}",
                },
                columns: [
                    {
                        data: 'id',
                        name: 'category_id',
                    },
                    {
                        data: 'name',
                        name: 'category_name',
                    },
                    {
                        data: 'parent',
                        name: 'parent.name',
                    },
                    {
                        data: 'action',
                        name: 'category_action',
                    },
                ]
            });

            // SELECT2
            $('.select2').select2({
                placeholder: 'Pilih induk kategori',
                allowClear: true,
                ajax:{
                    url: '/category/getParent',
                    dataType: 'json',
                    data: function (params){
                        return {
                            q: $.trim(params.term)
                        };
                    },
                    processResults: function (data){
                        return {
                            results: data
                        };
                    },
                    cache: true,
                }
            });

            $('#category_form_create').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data){
                        if(data.success){
                            Swal.fire('Success!', data.success, 'success');
                            $('#category_table').DataTable().ajax.reload();
                            $('#category_form_create')[0].reset();
                            $('.select2').val(null).trigger('change');
                        }
                        if(data.errors){
                            Swal.fire('Warning!', data.errors[0], 'warning');
                        }
                    }
                });
            });

            $('#category_table').on('click', '.delete-category', function(){
                var category_id = $(this).data('id');
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
                            url: '/category/delete/'+category_id,
                            success: function(data){
                                if(data.success){
                                    $('#category_table').DataTable().ajax.reload();
                                    Swal.fire('Success!', data.success, 'success');
                                }
                                if(data.warning){
                                    Swal.fire('Warning', data.warning, 'warning');
                                }
                            }
                        });
                    }
                });
            });

            $('#category_table').on('click', '.edit-category', function(){
                var category_id = $(this).data('id');
                var select2 = $('.select2edit');
                $.ajax({
                    url: '/category/detail/'+category_id,
                    success: function(data){
                        $('#category_edit').show();
                        $('#category_create').hide();
                        $('input[name="category_name"]').val(data.name);
                        $('input[name="category_id"]').val(data.id);
                        // create the option and append to Select2
                        if(data.parent_id == null){
                            var option = new Option('', '', true, true);
                        } else{
                            var option = new Option(data.parent.name, data.parent_id, true, true);
                        }
                        select2.append(option).trigger('change');

                        // manually trigger the `select2:select` event
                        select2.trigger({
                            type: 'select2:select',
                            params: {
                                data: data
                            }
                        });

                    }
                });
            });

            $('.cancel-button').on('click', function () {
                $('#category_edit').hide();
                $('#category_create').show();
                $('#category_form_create')[0].reset();
                $('#category_form_edit')[0].reset();
                $('.select2').val('').trigger('change');
            });

            $('#category_form_edit').on('submit', function(e){
                e.preventDefault();
                var category_id = $('input[name="category_id"]').val();
                console.log(category_id);
                $.ajax({
                    url: '/category/edit/'+category_id,
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data){
                        if(data.success){
                            Swal.fire('Success!', data.success, 'success');
                            $('#category_edit').hide();
                            $('#category_create').show();
                            $('#category_form_create')[0].reset();
                            $('#category_form_edit')[0].reset();
                            $('#category_table').DataTable().ajax.reload();
                        }
                        if(data.errors){
                            Swal.fire('Warning!', data.errors[0], 'warning');
                        }
                    }
                });

            });
        });
    </script>
@stop