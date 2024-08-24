<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CategoriController extends Controller
{
    public function index()
    {
        $response = Http::get('http://127.0.0.1:1005/api/categories'); // Ganti URL dengan API Anda
        $categories = $response->json()['data'];
        // dd($categories);
        // Kirim data kategori ke view
        return view('Categori', compact('categories'));
    }
}
