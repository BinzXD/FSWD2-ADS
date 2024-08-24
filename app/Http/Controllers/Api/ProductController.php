<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product_asset;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = Product::select(
                'id',
                'category_id',
                'name',
                'slug',
                'price'
            )
            ->with('categori:id,name' , 'assets:product_id,image')
            ->orderBy('price', 'desc') 
            ->get();
    
            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'Daftar produk berhasil diambil',
                'data' => $products,
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['slug'] = Str::slug($data['name']);
        $data['category_id'] = $request->input('category_id');


        try {
            $product = new Product($data);
            $product->save();

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('image', 'public');
                    $productAsset = new Product_asset([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                    $productAsset->save();
                }
            }


            return response()->json([
                'status' => true,
                'success'   => true,
                'message' => 'Product berhasil disimpan',
                'data' => new ProductResource($product->loadMissing('categori:id,name', 'assets:id,product_id,image'))
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'success'   => false,
                'message' => $e->getMessage(),
                'data'      => null
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->loadMissing(['categori:id,name', 'assets:id,product_id,image']);
            return new ProductResource($product);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'success'   => false,
                'message'   => $e->getMessage(),
                'data'      => null
            ], $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try {
            $product = Product::findOrFail($id);
            $data = $request->validated();
    
            if ($request->has('name')) {
                $data['slug'] = Str::slug($data['name']);
            }
    
            if ($request->hasFile('images')) {
                foreach ($product->assets as $productAsset) {
                    Storage::disk('public')->delete($productAsset->image); 
                    $productAsset->delete(); 
                }
    
                foreach ($request->file('images') as $file) {
                    $path = $file->store('image', 'public');
                    Product_asset::create([
                        'product_id' => $product->id,
                        'image' => $path,
                    ]);
                }
            }
            $product->update($data);
    
            return response()->json([
                'status' => true,
                'success' => true,
                'message' => 'Produk berhasil diperbarui',
                'data' => new ProductResource($product->loadMissing('categori:id,name', 'assets:id,product_id,image')),
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'status'    => true,
            'success'   => true,
            'message'   => 'Product berhasil dihapus',
        ], 200);
    }
}
