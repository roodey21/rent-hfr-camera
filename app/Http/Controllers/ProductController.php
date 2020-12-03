<?php

namespace App\Http\Controllers;

use App\Models\Category;
use File;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if(request()->ajax()){
            $products = Product::with(['categories', 'brand'])->limit(10);

            return DataTables::of($products)
                ->editColumn('brand_id', function(Product $product){
                    return $product->brand->name;
                })
                ->editColumn('name', function(Product $product){
                    return '<a href="/product/detail/'.$product->id.'" class="text-black">'.$product->name.'</a>';
                })
                ->addColumn('category', function(Product $product){
                    $cat = '';
                    foreach ($product->categories as $category ) {
                        $cat .= '<span class="badge badge-success mr-1">'.$category->name.'</span>'; 
                    }
                    return $cat;
                })
                ->addColumn('action', function($data){
                    $btn = '<button class="edit-product btn btn-primary btn-sm" data-id="'.$data->id.'">Edit</button>';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button class="delete-product btn btn-danger btn-sm" data-id="'.$data->id.'">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action','name', 'category'])
                ->make(true);
        }
        return view('products.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules = [
            'product_name'  =>  'required',
            'product_brand_id'  =>  'required',
            'product_category_id'  =>  'required',
            'product_summary'  =>  'required',
            'product_description'  =>  'required',
            'product_stock'  =>  'required',
            'product_SKU'  =>  'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);
        
        if($validator->fails()){
            return response()->json(['errors'   =>  $validator->errors()->all()]);
        }
        
        // return $request->all();
        $product = Product::create([
            'name'  =>  $request->product_name,
            'brand_id'  =>  $request->product_brand_id,
            'summary'  =>  $request->product_summary,
            'description'  =>  $request->product_description,
            'stock'  =>  $request->product_stock,
            'SKU'  =>  $request->product_SKU,
            'status'  =>  1,
        ]);
            
        foreach ($request->input('image', []) as $image) {
            $product->addMedia(storage_path('tmp/uploads/' . $image))->toMediaCollection('product');
        }

        $product->categories()->sync($request->product_category_id);
        
        return response()->json(['success'  =>  $product->name.' berhasil ditambahkan!']);
    }
        
    public function imageStore(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if(!file_exists($path)){
            mkdir($path, 0777,true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'  =>  $name,
            'original_name' =>  $file->getClientOriginalName(),
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $product = Product::with(['categories', 'brand'])->find($id);
        return view('products.detail', compact(['product']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        return view('products.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $product = Product::find($id);
        $product->delete();
        $product->categories()->detach();

        return response()->json(['success'  =>  'Produk Berhasil dihapus!']);
    }
}
