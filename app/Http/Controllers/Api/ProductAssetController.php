<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssetsRequest;
use App\Http\Resources\AssetResource;
use App\Models\Product_asset;
use Illuminate\Http\Request;

class ProductAssetController extends Controller
{
    public function store(AssetsRequest $request)
    {
        $data = $request->validated();
        $assets = [];
        try {
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('image', 'public');
                    $asset = Product_asset::create([
                        'product_id' => $data['product_id'],
                        'image' => $path,
                    ]);
                    $assets[] = new AssetResource($asset);
                }
            }
            return response()->json([
                'status' => true,
                'success'   => true,
                'message' => 'Asset berhasil disimpan',
                'data' =>   $assets
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


    public function destroy(string $id)
    {
        $asset = Product_asset::findOrFail($id);
        $asset->delete();
        return response()->json([
            'status'    => true,
            'success'   => true,
            'message'   => 'Assets berhasil dihapus',
        ], 200);
    }
}
