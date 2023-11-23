<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return response()->json($products,200);
    }

    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            $fields=$request->validate([
                'name'=>'required',
                'price'=>'required|integer',
                'description'=>'required',
                'image'=>'required'
            ]);

            $product=Product::create([
                'name'=>$fields['name'],
                'price'=>$fields['price'],
                'description'=>$fields['description'],
                'image'=>$fields['image']
            ]);
            DB::commit();
            return response()->json($product,200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try{
            DB::beginTransaction();
            $fields=$request->validate([
                'name' => 'required',
                'price' => 'required|numeric',
                'description' => 'nullable',
                'image' => 'required',
            ]);

            $product->update([
                'name'=>$fields['name'],
                'price'=>$fields['price'],
                'description'=>$fields['description']??$product->description,
                'image'=>$fields['image']
            ]);
            DB::commit();
            return response()->json($product,200);
        }catch (\Exception $e){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }

    public function destroy(Product $product)
    {
        try{
            DB::beginTransaction();
            $product->delete();
            DB::commit();
            return response()->json('Deleted success',200);
        }catch (\Exception $exception){
            DB::rollBack();
            return response()->json($e->errors(),500);
        }
    }
}
