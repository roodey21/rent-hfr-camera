@extends('adminlte::page')

@section('content_header')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Product Detail</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Product</a></li>
                <li class="breadcrumb-item active">Detail</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
                {{-- Judul Product --}}
              <h3 class="d-inline-block d-sm-none">{{ $product->name }}</h3>
              {{-- Media / Gambar product --}}
              <div class="col-12">
                <img src="{{ $product->getMedia('product')->first()->getUrl() }}" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                {{-- <div class="product-image-thumb active"><img src="{{ $product->getMedia('product')->first()->getUrl() }}" alt="Product Image"></div> --}}
                @foreach ($product->getMedia('product') as $item)
                    <div class="product-image-thumb" ><img src="{{ $item->getUrl() }}" alt="Product Image"></div>
                @endforeach
              </div>
            </div>
            <div class="col-12 col-sm-6">
                {{-- Judul / nama product --}}
              <h3 class="my-3">{{ $product->name }}</h3>
              <dl>
                  <dt>Brand</dt>
                  <dd>Random brand</dd>
                  <dt>Deskripsi</dt>
                  <dd>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Ipsum, beatae!</dd>
                  <dt>Category</dt>
                  <dd>
                    <ul>
                        @foreach ($product->categories as $category)
                          <li>{{ $category->name }}</li>                      
                        @endforeach
                    </ul>
                  </dd>
                  <dt>Harga</dt>
                  <dd>
                    <ul>
                        <li>12 jam   =   Rp. 100.000</li>
                        <li>24 jam   =   Rp. 150.000</li>
                        <li>48 jam   =   Rp. 250.000</li>
                    </ul>
                  </dd>
                  <div class="text-right">
                      <button class="btn btn-warning  shadow">Edit Product!</button>
                  </div>
              </dl>
            </div>
          </div>
          <div class="row mt-4">
            <nav class="w-100">
              <div class="nav nav-tabs" id="product-tab" role="tablist">
                <a class="nav-item nav-link active" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="true">Description</a>
                <a class="nav-item nav-link" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="false">Comments</a>
                <a class="nav-item nav-link" id="product-rating-tab" data-toggle="tab" href="#product-rating" role="tab" aria-controls="product-rating" aria-selected="false">Rating</a>
              </div>
            </nav>
            <div class="tab-content p-3" id="nav-tabContent">
              <div class="tab-pane fade show active" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">{{ $product->description }}</div>
              <div class="tab-pane fade" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab"></div>
              <div class="tab-pane fade" id="product-rating" role="tabpanel" aria-labelledby="product-rating-tab"> Cras ut ipsum ornare, aliquam ipsum non, posuere elit. In hac habitasse platea dictumst. Aenean elementum leo augue, id fermentum risus efficitur vel. Nulla iaculis malesuada scelerisque. Praesent vel ipsum felis. Ut molestie, purus aliquam placerat sollicitudin, mi ligula euismod neque, non bibendum nibh neque et erat. Etiam dignissim aliquam ligula, aliquet feugiat nibh rhoncus ut. Aliquam efficitur lacinia lacinia. Morbi ac molestie lectus, vitae hendrerit nisl. Nullam metus odio, malesuada in vehicula at, consectetur nec justo. Quisque suscipit odio velit, at accumsan urna vestibulum a. Proin dictum, urna ut varius consectetur, sapien justo porta lectus, at mollis nisi orci et nulla. Donec pellentesque tortor vel nisl commodo ullamcorper. Donec varius massa at semper posuere. Integer finibus orci vitae vehicula placerat. </div>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  <!-- /.content-wrapper -->
@endsection