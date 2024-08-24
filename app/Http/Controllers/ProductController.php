<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Categorie;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Product_asset;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $response = Http::get('http://127.0.0.1:1005/api/products'); 
        $produk = $response->json()['data'];
        return view('product.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Categorie::all();
        return view('product.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $client = new Client();
        $url = "http://127.0.0.1:1005/api/products";
        $multipartData = [
            ['name' => 'name', 'contents' => $request->name],
            ['name' => 'price', 'contents' => $request->price],
            ['name' => 'category_id', 'contents' => $request->category_id]
        ];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $multipartData[] = [
                    'name'     => 'images[]',
                    'contents' => fopen($image->getPathname(), 'r'),
                    'filename' => $image->getClientOriginalName()
                ];
            }
        }
        $response = $client->request('POST', $url, ['multipart' => $multipartData]);
        $contentArray = json_decode($response->getBody()->getContents(), true);
        if (!$contentArray['status']) {
            return redirect()->to('product')->withErrors($contentArray['data'])->withInput();
        }
        return redirect()->to('product')->with('Success', 'Product berhasil disimpan');
    } 
           
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:1005/api/products/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if ($contentArray['status'] != true){
            $eror = $contentArray['data'];
            return redirect()->to('product')->withErrors($eror)->withInput();
        } else {
            $data = $contentArray['data'];
            return view('product.edit', compact('data'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $client = new Client();
    $url = "http://127.0.0.1:1005/api/products/{$id}";

    // Data form
    $multipartData = [
        ['name' => 'name', 'contents' => $request->name],
        ['name' => 'price', 'contents' => $request->price],
        ['name' => 'category_id', 'contents' => $request->category_id]
    ];

    // Menambahkan file gambar jika ada
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $multipartData[] = [
                'name'     => 'images[]',
                'contents' => fopen($image->getPathname(), 'r'),
                'filename' => $image->getClientOriginalName()
            ];
        }
    }

    try {
        $response = $client->request('POST', $url, ['multipart' => $multipartData]);
        $contentArray = json_decode($response->getBody()->getContents(), true);

        if (!$contentArray['status']) {
            return redirect()->to('product')->withErrors($contentArray['data'])->withInput();
        }

        return redirect()->to('product')->with('Success', 'Product berhasil diperbarui');
    } catch (\Exception $e) {
        return redirect()->to('product')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()])->withInput();
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = new Client();
        $url = "http://127.0.0.1:1005/api/products/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        if ($contentArray['status'] != true){
            $eror = $contentArray['data'];
            return redirect()->to('product')->withErrors($eror)->withInput();
        } else {
            return redirect()->to('product')->with('Success','Product berhasil dihapus' );
        }
    }
}
