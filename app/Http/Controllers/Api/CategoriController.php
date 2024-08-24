<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriRequest;
use App\Http\Resources\CategoriResource;
use App\Models\Categorie;


class CategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Categorie::select(
            'id',
            'name',
        )
        ->withCount('product')
        ->orderBy('product_count', 'desc')
        ->get();

        return response()->json([
            'status'    => true,
            'data'      => $categories,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriRequest $request)
    {
        $data = $request->validated();
        try {
            $categori = new Categorie($data);
            $categori->save();
            return response()->json([
                'status' => true,
                'success'   => true,
                'message' => 'Categori berhasil disimpan',
                'data' => new CategoriResource($categori)
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriRequest $request, string $id)
    {
        $categori = Categorie::findOrFail($id);
        $data = $request->validated();
        try {
            $categori->update($data);
            return response()->json([
                'status'    => true,
                'success'   => true,
                'message'   => 'Perubahan Berhasil Disimpan',
                'data'      => new CategoriResource($categori)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status'    => false,
                'success'   => false,
                'message'   => $e->getMessage(),
                'data'      => null
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
