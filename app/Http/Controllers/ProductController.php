<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductDetail;
use Exception;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProductStore;
use App\Http\Requests\ProductUpdate;
use App\Http\Transformers\ResponseTransformer;

class ProductController extends Controller
{

    public function index()
    {
        try {
            DB::beginTransaction();

            $products = Product::all();

            return (new ResponseTransformer($products))->toJson();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }


    public function store(ProductStore $request)
    {
        try {
            DB::beginTransaction();

            $request->merge(['id' => Str::uuid()]);
            $product = Product::create($request->only([
                'code', 'title', 'description', 'price', 'id'
            ]));

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show(ProductDetail $request)
    {
        try {
            $product = Product::find($request->id);
            return $product;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update(ProductUpdate $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('id', $request->id)->update($request->only([
                'code', 'title', 'description', 'price'
            ]));

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function destroy(ProductDetail $request)
    {
        try {
            DB::beginTransaction();

            $product = Product::where('id', $request->id)->delete();

            DB::commit();
            return $product;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
