@extends('adminlte::page')

@section('content_header')
<div class="row">
    <div class="col">
        <h1>Tambah Product Baru</h1>
    </div>
    <div class="col text-right">
        <a href="{{ route('product.index') }}" class="btn btn-danger">Kembali</a>
    </div>
</div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('theme/plugin/Dropzone/dropzone.min.css') }}">
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <div class="card-title">
                            Form Tambah Product Baru
                        </div>
                    </div>
                    <div class="card-body">
                        {{-- <form action="/file-upload" class="dropzone mb-2" id="my-awesome-dropzone"></form> --}}
                        <form action="{{ route('product.store') }}" id="product_form_create" method="post">
                            @csrf
                                <div class="form-group">
                                    <label for="product_name">Nama</label>
                                    <input name="product_name" type="text" placeholder="Masukkan nama produk" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Foto Produk</label>
                                    <div id="image-dropzone" class="dropzone needsclick">

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_brand_id">Brand</label>
                                            <select name="product_brand_id" style="width: 100%" class="form-control select2 brand-select"></select>
                                            <span class="text-sm"><a class="text-purple" href="#">+ Atau buat brand baru</a></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_category_id">Category</label>
                                            <select style="width: 100%" name="product_category_id[]" multiple class="form-control select2 category-select"></select>
                                            <span class="text-sm"><a class="text-purple" href="#">+ Atau buat category baru</a></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="product_summary">Deskripsi Singkat</label>
                                    <textarea name="product_summary" class="form-control"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="product_description">Deskripsi Lengkap</label>
                                    <textarea name="product_description" class="form-control"></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_stock">Stok</label>
                                            <input type="number" name="product_stock" placeholder="Jumlah stok produk" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="product_SKU">SKU</label>
                                            <input type="text" name="product_SKU" placeholder="Masukkan kode SKU (Stock Keeping Unit)" class="form-control">
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

@section('js')
<script type="text/javascript" src="{{ asset('theme/plugin/Dropzone/dropzone.min.js') }}"></script>
<script>
    var uploadedImageMap = {}
    Dropzone.options.imageDropzone = {
        url: '{{ route('product.image.store') }}',
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        headers: {
        'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="image[]" value="' + response.name + '">')
            uploadedImageMap[file.name] = response.name
        },
        removedfile: function (file) {
            file.previewElement.remove()
            var name = ''
            if (typeof file.file_name !== 'undefined') {
                name = file.file_name
            } else {
                name = uploadedImageMap[file.name]
            }
            $('form').find('input[name="image[]"][value="' + name + '"]').remove()
        },
        init: function () {
        @if(isset($product) && $product->image)
            var files =
            {!! json_encode($project->document) !!}
            for (var i in files) {
            var file = files[i]
            this.options.addedfile.call(this, file)
            file.previewElement.classList.add('dz-complete')
            $('form').append('<input type="hidden" name="document[]" value="' + file.file_name + '">')
            }
        @endif
        }
    }
</script>
<script>
    $(function(){
        $('.category-select').select2({
            placeholder: 'Pilih Kategori',
            allowClear: true,
            ajax:{
                url: '/category/getData',
                dataType: 'json',
                delay: 250,
                processResults: function (data){
                    return {
                        results: $.map(data, function(item){
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
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
                delay: 250,
                processResults: function (data){
                    return {
                        results: $.map(data, function(item){
                            return {
                                text : item.name,
                                id : item.id
                            }
                        })
                    };
                },
                cache: true,
            }
        });
    });

    $('#product_form_create').on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            data: $(this).serialize(),
            method: 'post',
            success: function(data){
                if(data.success){
                    Swal.fire({
                        title: data.success,
                        text: "Apakah anda ingin menambahkan product lainnya?",
                        icon: 'success',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, tambah product lainnya',
                        cancelButtonText: 'tidak'
                        }).then((result) => {
                            $('#product_form_create')[0].reset();
                            $('.select2').val(null).trigger('change');
                            if (result.isDismissed) {
                                window.location.href="{{ route('product.index') }}";
                            }
                    });
                }
                if(data.errors){
                    Swal.fire('Warning', data.errors[0], 'warning');
                }
            }
        })
    });
</script>
@endsection