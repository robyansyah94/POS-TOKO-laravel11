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
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$produk->id_produk])) {
            $keranjang[$produk->id_produk]['jumlah'] += 1;
        } else {
            $keranjang[$produk->id_produk] = [
                'nama_produk' => $produk->nama_produk,
                'stok' => $produk->stok,
                'harga' => $produk->harga,
                'jumlah' => 1
            ];
        }

        session(['keranjang' => $keranjang]);

        if ($request->ajax()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->back();
    }

    
    public function panelTransaksi()
    {
        $keranjang = session('keranjang', []);
        return view('Kasir.panel-transaksi', compact('keranjang'));
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
