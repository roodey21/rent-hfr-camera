@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<div class="row">
    <div class="col">
        <h1>Dashboard</h1>
    </div>
    <div class="col text-right">
        <a href="{{ route('product.create') }}" class="btn btn-sm btn-primary">Tambah Product Baru</a>
        {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".product-create">Extra large modal</button> --}}
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
                            <table class="table table-bordered table-striped" id="product_table">
                                <thead>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Brand</th>
                                    <th>Kategori</th>
                                    <th>Stok</th>
                                    <th>SKU</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            {{-- Modal create --}}
            <div class="modal modal-primary fade product-create" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">Title</div>
                        </div>
                        <form action="{{ route('product.store') }}" id="product_form_create" method="post">
                            @csrf
                        <div class="modal-body">
                                <div class="form-group">
                                    <label for="product_name">Nama</label>
                                    <input name="product_name" type="text" class="form-control">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_brand_id">Brand</label>
                                            <select name="product_brand_id" style="width: 100%" class="form-control brand-select"></select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Category</label>
                                            <select style="width: 100%" name="product_category_id[]" multiple class="form-control category-select"></select>
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
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            {{-- Modal edit --}}
            {{-- Modal bootstrap --}}
            <div class="modal modal-primary fade product-edit" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title">Title</div>
                        </div>
                        <form action="#" id="product_form_edit" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="product_name">Nama</label>
                                    <input name="product_name" type="text" class="form-control product-name">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_brand_id">Brand</label>
                                            <select name="product_brand_id" style="width: 100%" class="form-control brand-select"></select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Category</label>
                                            <select style="width: 100%" name="product_category_id[]" multiple class="form-control category-select"></select>
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
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
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
            $('#product_table').DataTable({
                processing: true,
                serverside: true,
                ajax: {
                    url: "{{ route('product.index') }}",
                },
                columns: [
                    { data: 'id', name: 'product_id', }, { data: 'name', name: 'product_name', }, { data: 'brand_id', name: 'brand.name', }, { data: 'category', name: 'category.name', }, { data: 'stock', name: 'product_stock', }, { data: 'SKU', name: 'product_SKU', }, { data: 'status', name: 'product_status', }, { data: 'action', name: 'product_action', },
                ]
            });

            // SELECT2
            $('.category-select').select2({
                placeholder: 'Pilih induk kategori',
                allowClear: true,
                ajax:{
                    url: '/category/getData',
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

            $('.brand-select').select2({
                placeholder: 'Pilih Brand',
                allowClear: true,
                ajax:{
                    url: '/brand/getData',
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

            $('#product_form_create').on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'post',
                    data: $(this).serialize(),
                    success: function(data){
                        if(data.success){
                            Swal.fire('Success!', data.success, 'success');
                            $('#product_table').DataTable().ajax.reload();
                            $('#product_form_create')[0].reset();
                            $('.select2').val(null).trigger('change');
                        }
                        if(data.errors){
                            Swal.fire('Warning!', data.errors[0], 'warning');
                        }
                    }
                });
            });

            $('#product_table').on('click', '.delete-product', function(){
                var product_id = $(this).data('id');
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
                            url: '/product/delete/'+product_id,
                            success: function(data){
                                if(data.success){
                                    $('#product_table').DataTable().ajax.reload();
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

            $('#product_table').on('click', '.edit-product', function(){
                var product_id = $(this).data('id');
                // var select2 = $('.select2edit');
                $.ajax({
                    url: '/product/detail/'+product_id,
                    success: function(data){
                        $('.product-edit').modal('show');
                        $('.product-edit input[name="product_name"]').val(data.name);
                        var optionBrand = new Option(data.brand.name, data.brand.id, true, true);
                        $('.product-edit .brand-select').append(optionBrand).trigger('change');
                        // $('.product-edit .category-select').append(optionCategory).trigger('change');
                        // .val(data.name);
                        // $('#category_create').hide();
                        // $('input[name="category_name"]').val(data.name);
                        // $('input[name="category_id"]').val(data.id);
                        // create the option and append to Select2
                        // if(data.parent_id == null){
                        //     var option = new Option('', '', true, true);
                        // } else{
                        //     var option = new Option(data.parent.name, data.parent_id, true, true);
                        // }
                        // select2.append(option).trigger('change');

                        // manually trigger the `select2:select` event
                        // select2.trigger({
                        //     type: 'select2:select',
                        //     params: {
                        //         data: data
                        //     }
                        // });

                    }
                });
            });

            // $('.cancel-button').on('click', function () {
            //     $('#category_edit').hide();
            //     $('#category_create').show();
            //     $('#category_form_create')[0].reset();
            //     $('#category_form_edit')[0].reset();
            //     $('.select2').val('').trigger('change');
            // });

            // $('#category_form_edit').on('submit', function(e){
            //     e.preventDefault();
            //     var category_id = $('input[name="category_id"]').val();
            //     console.log(category_id);
            //     $.ajax({
            //         url: '/category/edit/'+category_id,
            //         method: 'post',
            //         data: $(this).serialize(),
            //         success: function(data){
            //             if(data.success){
            //                 Swal.fire('Success!', data.success, 'success');
            //                 $('#category_edit').hide();
            //                 $('#category_create').show();
            //                 $('#category_form_create')[0].reset();
            //                 $('#category_form_edit')[0].reset();
            //                 $('#category_table').DataTable().ajax.reload();
            //             }
            //             if(data.errors){
            //                 Swal.fire('Warning!', data.errors[0], 'warning');
            //             }
            //         }
            //     });

            // });
        });
    </script>
@stop