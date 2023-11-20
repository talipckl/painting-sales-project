<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function index()
    {
        try {
            $data = Product::all();

            return ProductResource::collection($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }
    public function mylist()
    {
        try {
            $supplier_id = auth('supplier')->user()->id;
            $data = Product::query()
            ->where('supplier_id',$supplier_id)
            ->get();

            return ProductResource::collection($data);
        }catch (\Exception $e){
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }



    public function store(StoreProductRequest $request,StoreImageRequest $imageRequest)
    {
        try {
            DB::beginTransaction();
            $supplier_id = auth('supplier')->user()->id;
            $req_data = $request->only([
                'supplier_id',
                'category_id',
                'title',
                'description',
                'quantity',
                'frame_size',
                'price',
                'discount',
            ]);
            $req_data['supplier_id'] = $supplier_id;
            $data = new Product($req_data);
            $data->save();
            $product_id = $data->id;
            $images = $imageRequest->input('images');
            foreach ($images as $img){
                $img['supplier_id'] =$supplier_id;
                $img['product_id'] =$product_id;
                $img_data = new Image($img);
                $img_data->save();
            }
            DB::commit();

            return ProductResource::make($data);
        }catch (\Exception $e){
            DB::rollBack();
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
            $data = Product::findOrFail($id);

            return ProductResource::make($data);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }

    public function update($id,UpdateProductRequest $request,StoreImageRequest $imageRequest)
    {
        try {
            $supplier_id = auth('supplier')->user()->id;
            $product_data = Product::findOrFail($id);
            $req_data = $request->only([
                'category_id',
                'title',
                'description',
                'quantity',
                'frame_size',
                'price',
                'discount',
            ]);
            $req_data['supplier_id'] = $supplier_id;
            $product_data->update($req_data);
            $product_id = $product_data->id;
            $images = $imageRequest->input('images');
            foreach ($images as $img){
                if (empty($img['id'])){
                    $img['supplier_id'] =$supplier_id;
                    $img['product_id'] =$product_id;
                    $img_data = new Image($img);
                    $img_data->save();
                }else{
                    $img_data = Image::findOrFail($img['id']);
                    $img['supplier_id'] =$supplier_id;
                    $img['product_id'] =$product_id;
                    $img_data->update($img);
                }
            }
            DB::commit();

            return ProductResource::make($product_data);
        }catch (\Exception $e){
            DB::rollBack();
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
            $data  = Product::findOrFail($id);
            $img_data = Image::where('product_id',$id)->get();
            $img_data->each(function ($detail) {
                $detail->delete();
            });
            $data->delete();

            return  response()->json([
                'status'=>true,
                'message'=>'Successfully is Deleted!'
            ],200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }
    public function destroyImage($id)
    {
        try {
            $img_data = Image::findOrFail($id);

            $img_data->delete();

            return  response()->json([
                'status'=>true,
                'message'=>'Successfully is Deleted!'
            ],200);

        }catch (\Exception $e){
            DB::rollBack();
            return response()->json([
                'status'=>false,
                'message'=>'Internal Error!',
                'log'=>$e->getMessage()
            ],500);
        }
    }
}
