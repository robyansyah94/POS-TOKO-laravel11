<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Http\Request;

class kasirController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\produk::all();
        return view('Kasir/index')->with($data);
    }

    public function store(Request $request)
    {
        $produk = produk::findOrFail($request->id_produk);

        $kerajang = session()->get('keranjang', []);
        
        if (isset($kerajang[$produk->id_produk])) {
            $kerajang[$produk->id_produk]['jumlah'] += 1;
        } else {
            $kerajang[$produk->id_produk] = [
                'nama_produk' => $produk->nama_produk,
                'stok' => $produk->stok,
                'harga' => $produk->harga,
                'jumlah' => 1
            ];
        }
        session(['keranjang' => $kerajang]);

        return redirect()->back();
    }

    public function tambah($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += 1;
        }

        session(['keranjang' => $keranjang]);
        return redirect()->back();
    }

    public function kurang($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] -= 1;
        }

        session(['keranjang' => $keranjang]);
        return redirect()->back();
    }

    public function hapusSemua()
    {
        session()->forget('keranjang');
        return redirect()->back();
    }
}
