<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class produkController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\produk::all();
        return view('produk/index')->with($data);
    }

    public function create()
    {
        return view('produk/form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'stok' => 'required|max:100',
            'harga' => 'required|max:100',
            'id_kategori' => 'required|exists:t_kategori',
        ]);

        $input = $request->all();
        $status = \App\Models\produk::create($input);

        if ($status) return redirect('/produk')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk/add')->with('error', 'Data Gagal ditambahkan');
    }

    public function edit($id)
    {
        $data['result'] = \App\Models\produk::where('nis', $id)->first();
        return view('produk/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_produk' => 'required|max:100',
            'stok' => 'required|max:100',
            'harga' => 'required|max:100',
            'id_kategori' => 'required|exists:t_kategori',
        ]);

        $input = $request->all();
        $result = \App\Models\produk::where('id_produk', $id)->first();
        $status = $result->update($input);

        if ($status) return redirect('/produk')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk/add')->with('error', 'Data Gagal ditambahkan');
    }
}
