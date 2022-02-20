<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Qualification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::with(['categories','qualification'])->orderby('id','desc')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'sku' => 'required|max:255',
                'name' => 'required|max:255',
                'price' => 'numeric|min:0',
                'amount' => 'numeric|min:0',
                'status' => 'required',
                'category' => 'required',
            ]);
            $product = new Product;
            $product->sku=$request->sku;
            $product->name=$request->name;
            $product->price=$request->price;
            $product->amount=$request->amount;
            $product->status=$request->status;
            if ($product->save()) {
                    $category = new ProductCategory;
                    $category->product_id=$product->id;
                    $category->category_id=$request->category;
                    $category->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
        
    }
    public function qualification(Request $request){
        try {
            $request->validate([
                'calific' => 'required',
            ]);
            $qualification = new Qualification;
            $qualification->qualification=$request->calific;
            $qualification->product_id=$request->id;
            if ($qualification->save()) {
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return Product::with(['categories','qualification'])->where('id',$product->id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            $request->validate([
                'sku' => 'required|max:255',
                'name' => 'required|max:255',
                'price' => 'numeric|min:0',
                'amount' => 'numeric|min:0',
                'status' => 'required',
                'category' => 'required',
            ]);
            $product->sku=$request->sku;
            $product->name=$request->name;
            $product->price=$request->price;
            $product->amount=$request->amount;
            $product->status=$request->status;
            if ($product->update()) {
                ProductCategory::where('product_id',$product->id)->deleted();
                    $category = new ProductCategory;
                    $category->product_id=$product->id;
                    $category->category_id=$request->category;
                    $category->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
    }
    public function stock($id){
        $product=Product::where('id',$id)->first();
        $product->status=($product->status==1)? 0:1;
        $product->update();
    }
}
