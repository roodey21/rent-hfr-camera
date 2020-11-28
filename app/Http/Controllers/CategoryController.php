<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
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
            $categories = Category::with('parent')->latest()->get();
            return DataTables::of($categories)
                ->addColumn('action', function($data){
                    $btn = '<button class="edit-category btn btn-primary btn-sm" data-id="'.$data->id.'">Edit</button>';
                    $btn .= '&nbsp;&nbsp;&nbsp;<button class="delete-category btn btn-danger btn-sm" data-id="'.$data->id.'">Delete</button>';
                    return $btn;
                })
                ->addColumn('parent', function(Category $category){
                    if(!$category->parent){
                        return '-';    
                    } else{
                        return $category->parent->name;
                    }
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('categories.index');
    }

    public function getParent(Request $request)
    {
        $term = trim($request->term);

        // if(empty($term)) {
        //     return response()->json([]);
        // }

        $parents = Category::getParent()->where('name','like','%'.$term.'%')->limit(5)->get();

        $data = [];
        foreach ($parents as $parent) {
            $data[] = ['id' =>  $parent->id,'text'  =>  $parent->name];
        }
        return response()->json($data);
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
        $rules = ['category_name'  =>  'required'];

        $validation = Validator::make($request->all(), $rules);

        if ($validation->fails()){
            return response()->json(['errors'    =>  $validation->errors()->all()]);
        }

        Category::create([
            'name'  =>  $request->category_name,
            'parent_id' =>  $request->category_parent_id,
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
        $category = Category::with('parent')->find($id);
        return response()->json($category);
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
        $rules = ['category_name'   =>  'required'];
        $validation = Validator::make($request->all(), $rules);
        if($validation->fails()){
            return response()->json(['errors'    =>  $validation->errors()->all()]);
        }
        $category = Category::find($id);
        $category->update([
            'name'  =>  $request->category_name,
            'parent_id' =>  $request->category_parent_id
        ]);

        return response()->json(['success'  =>  'data berhasil diupdate']);
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
        $category = Category::withCount('child')->find($id);
        if($category->child_count == 0){
            $category->delete();
            return response()->json(['success'  =>  'Category '.$category->name.' berhasil dihapus']);
        } else{
            return response()->json(['warning'  =>  $category->name.' mempunyai kategori turunan']);
        }
    }
}
