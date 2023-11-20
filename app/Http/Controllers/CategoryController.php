<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $data = Category::all();

            return  CategoryResource::collection($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            $req_data = $request->only([
               'name',
               'parent_id',
               'description'
            ]);
            $data = new Category($req_data);
            $data->save();

            return  CategoryResource::make($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }

    public function show($id)
    {
        try {
            $data = Category::findOrFail($id);

            return CategoryResource::make($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        try {
            $data = Category::findOrFail($id);
            $req_data = $request->only([
                'name',
                'parent_id',
                'description'
            ]);
            $data->update($req_data);

            return  CategoryResource::make($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }

    public function destroy($id)
    {
        try {
           $data = Category::findOrFail($id);
           $data->delete();

           return response()->json([
               'status'=>true,
               'message'=>'Successfully is Deleted!'
           ],200);

        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }
}
