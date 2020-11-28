@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col">
        <h1>Dashboard</h1>
    </div>
    <div class="col text-right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".product-create">Extra large modal</button>
    </div>
</div>
@stop

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
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
        <div class="row">
            {{-- Modal bootstrap --}}
            <div class="modal modal-primary fade product-create" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">Title</div>
                        </div>
                        <div class="modal-body">
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label for="product_name">Nama</label>
                                    <input name="product_name" type="text" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_brand_id">Brand</label>
                                            <input type="text" name="product_brand_id" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Category</label>
                                            <select name="product_category_id" class="form-control"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product_summary">Deskripsi Singkat</label>
                                    <textarea name="product_summary" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="product_description">Deskripsi Singkat</label>
                                    <textarea name="product_description" class="form-control"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_stock">Stok</label>
                                            <input type="number" name="product_stock" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_SKU">SKU</label>
                                            <input type="text" name="product_SKU" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary">Submit</button>
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
    {{-- <script>
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
    </script> --}}
@stop