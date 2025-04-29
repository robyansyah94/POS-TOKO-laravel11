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
            'nis' => 'required|unique:t_produk',
            'nama_lengkap' => 'required|max:100',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
            'id_kelas' => 'required|exists:t_kelas',
        ]);

        $input = $request->all();
        $status = \App\Models\produk::create($input);

        if ($status) return redirect('/')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk')->with('error', 'Data Gagal ditambahkan');
    }

    public function edit($id)
    {
        $data['result'] = \App\Models\produk::where('nis', $id)->first();
        return view('siswa/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_produk' => 'rrequired|max:100',
            'nama_produk' => 'required|max:100',
            'stok' => 'required',
            'harga' => 'required',
        ]);

        $input = $request->all();
        $result = \App\Models\produk::where('id_produk', $id)->first();
        $status = $result->update($input);

        if ($status) return redirect('/')->with('success', 'Data Berhasil ditambahkan');
        else return redirect('produk')->with('error', 'Data Gagal ditambahkan');
    }
}
