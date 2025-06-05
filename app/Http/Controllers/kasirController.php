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
        // *Pastikan Anda benar‐benar ambil key 'id_produk'*
        $id = $request->input('id_produk');
        $product = Produk::find($id);
        if (!$product) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        // Ambil isi keranjang sekarang
        $keranjang = session('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah']++;
        } else {
            $keranjang[$id] = [
                'nama_produk' => $product->nama_produk,
                'harga'       => $product->harga,
                'stok'        => $product->stok,
                'jumlah'      => 1,
            ];
        }

        session()->put('keranjang', $keranjang);

        // DEBUG (hapus setelah yakin benar)
        // dd(session('keranjang'));
        return response()->json(['success' => true]);
    }


    public function panelTransaksi()
    {
        $keranjang = session('keranjang', []);
        return view('Kasir.panel-transaksi', compact('keranjang'));
    }


    public function tambah($id)
    {
        $produk = \App\Models\Produk::find($id);

        if (!$produk) {
            return response()->json(['status' => 'error', 'message' => 'Produk tidak ditemukan'], 404);
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] += 1;
        } else {
            $keranjang[$id] = [
                'nama_produk' => $produk->nama_produk,
                'harga' => $produk->harga,
                'stok' => $produk->stok,
                'jumlah' => 1
            ];
        }

        session(['keranjang' => $keranjang]);

        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->back();
    }


    public function kurang($id)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$id])) {
            $keranjang[$id]['jumlah'] -= 1;
        }

        session(['keranjang' => $keranjang]);

        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->back();
    }

    public function hapusSemua()
    {
        session()->forget('keranjang');

        if (request()->ajax()) {
            return response()->json(['status' => 'success']);
        }

        return redirect()->back();
    }



    public function scan(Request $request)
    {
        $sku = $request->input('sku');
        $produk = Produk::where('sku', $sku)->first();

        if (!$produk) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$produk->id])) {
            if ($keranjang[$produk->id]['jumlah'] < $produk->stok) {
                $keranjang[$produk->id]['jumlah'] += 1;
            }
        } else {
            $keranjang[$produk->id] = [
                'nama_produk' => $produk->nama_produk,  // ini juga perlu diganti jadi 'nama_produk' sesuai produk
                'harga' => $produk->harga,
                'jumlah' => 1,
                'stok' => $produk->stok,
            ];
        }

        session(['keranjang' => $keranjang]);

        return redirect()->back();
    }
}
