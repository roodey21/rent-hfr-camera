<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (request()->ajax()) {
            $brands = Brand::latest()->get();
            return DataTables::of($brands)
                ->addColumn('action', function($data){
                    $btn = '<button class="edit-brand btn btn-primary btn-sm" data-id="'.$data->id.'">Edit</button>';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button class="delete-brand btn btn-danger btn-sm" data-id="'.$data->id.'">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('brands.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $rules = ['brand_name'  =>  'required'];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()){
            return response()->json(['errors'    =>  $validation->errors()->all()]);
        }

        Brand::create([
            'name'  =>  $request->brand_name
        ]);

        return response()->json(['success'  =>  'data berhasil ditambahkan!']);
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
        $brand = Brand::find($id);
        return response()->json($brand);
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
        $brand = Brand::find($id);
        $brand->update([
            'name'  =>  request('brand_name')
        ]);

        return response()->json(['success'  =>  'Data berhasil diupdate']);

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
        $brand = Brand::find($id);
        $brand->delete();

        return response()->json(['success'  =>  $brand->name.' berhasil dihapus']);
    }
}
