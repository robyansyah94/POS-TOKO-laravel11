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
            'sku'         => 'required|string|unique:t_produk,sku',
            'stok'        => 'required|max:100',
            'harga'       => 'required|max:100',
            'id_kategori' => 'required|exists:t_kategori',
            'foto'        => 'required|mimes:jpeg,png|max:512',
        ]);

        $input = $request->all();

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $filename = $input['nama_produk'] . "." . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('', $filename);
            $input['foto'] = $filename;
        }

        $status = \App\Models\produk::create($input);

        if ($status) return redirect('/produk')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk/add')->with('error', 'Data Gagal ditambahkan');
    }

    public function edit($id)
    {
        $data['result'] = \App\Models\produk::where('id_produk', $id)->first();
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

        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $filename = $input['nama_produk'] . "." . $request->file('foto')->getClientOriginalExtension();
            $request->file('foto')->storeAs('', $filename);
            $input['foto'] = $filename;
        }

        $status = $result->update($input);

        if ($status) return redirect('/produk')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk/add')->with('error', 'Data Gagal ditambahkan');
    }

    public function destroy(Request $request, $id)
    {
        $result = \App\Models\produk::where('id_produk', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('/produk')->with('success', 'Data Berhasil dihapus');
        else return redirect('produk/add')->with('error', 'Data Gagal dihapus');
    }
}
