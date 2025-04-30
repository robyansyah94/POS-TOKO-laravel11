<?php

namespace App\Http\Controllers;

use App\Models\kategori;
use Illuminate\Http\Request;

class kategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['result'] = \App\Models\kategori::all();
        return view('kategori/index')->with($data);
    }

    public function create()
    {
        return view('kategori/form');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi'    => 'required|max:100'
        ]);

        $input = $request->all();
        $status= \App\Models\kategori::create($input);

        if ($status) return redirect('/')->with('success','Data Berhasil ditambahkan');
        else return redirect('kategori')->with('error','Data Gagal ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function edit($id)
    {
        $data['result'] = \App\Models\kategori::where('id_kategori', $id)->first();
        return view('kategori/form')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|max:100',
            'deskripsi'    => 'required|max:100',
        ]);

        $input = $request->all();
        $result = \App\Models\kategori::where('id_kategori', $id)->first();
        $status= $result->update($input);

        if ($status) return redirect('/')->with('success','Data Berhasil diubah');
        else return redirect('/')->with('error','Data Gagal diubah');
    }

    public function destroy(Request $request, $id)
    {
        $result = \App\Models\kategori::where('id_kategori', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('/')->with('success','Data Berhasil dihapus');
        else return redirect('/')->with('error','Data Gagal dihapus');
    }  
}
