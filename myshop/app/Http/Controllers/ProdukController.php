<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produk = Produk::paginate(20);
        $kategori = Kategori::all();
        return view('page.produk.index', compact('produk'))->with([
            'kategori' => $kategori
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:kategori,id',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Initialize the finalname variable to handle both cases (image provided or not)
        $finalname = null;

        // Check if the file exists
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if ($image->isValid()) {
                $finalname = $image->store('produk', 'public');
            }
        } 

        Produk::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $finalname,
        ]);

        return back()->with('message_success', 'Produk berhasil ditambahkan!');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate input
        $request->validate([
            'name_edit' => 'required|string|max:255',
            'category_id_edit' => 'required|exists:kategori,id',
            'jumlah_edit' => 'required|integer|min:1',
            'satuan_edit' => 'required|string',
            'harga_beli_edit' => 'required|numeric|min:0',
            'harga_jual_edit' => 'required|numeric|min:0',
            'stock_edit' => 'required|integer|min:0',
            'description_edit' => 'nullable|string',
            'image_edit' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = [
            'name' => $request->input('name_edit'),
            'category_id' => $request->input('category_id_edit'),
            'jumlah' => $request->input('jumlah_edit'),
            'satuan' => $request->input('satuan_edit'),
            'harga_beli' => $request->input('harga_beli_edit'),
            'harga_jual' => $request->input('harga_jual_edit'),
            'stock' => $request->input('stock_edit'),
            'description' => $request->input('description_edit'),
        ];

        if ($request->hasFile('image_edit')) {
            $image = $request->file('image_edit');
            if ($image->isValid()) {
            $data['image'] = $image->store('produk', 'public');
            }
        }

        $produk = Produk::findOrFail($id);
        $produk->update($data);

        return back()->with('message_success', 'Produk berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //create function to delete image file
        $produk = Produk::findOrFail($id);
        if ($produk->image && Storage::disk('public')->exists($produk->image)) {
            Storage::disk('public')->delete($produk->image);
        }
        $produk->delete();
        return back()->with('message_success', 'Produk berhasil dihapus!');
    }
}
