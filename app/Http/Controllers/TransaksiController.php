<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\produk;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller
{
    //TAMPILAN
    public function index()
    {
        $data['result'] = \App\Models\Order::all();
        return view('Transaksi/index')->with($data);
    }


    // Transaksi
    public function bayar(Request $request)
    {
        $keranjang = session('keranjang', []);
        if (count($keranjang) == 0) {
            return redirect()->back()->with('error', 'Keranjang kosong!');
        }

        // Hitung subtotal dan pajak
        $subtotal = 0;
        foreach ($keranjang as $item) {
            $subtotal += $item['harga'] * $item['jumlah'];
        }
        $pajak = $subtotal * 0.11;
        $total = $subtotal + $pajak;

        // Validasi uang yang diberikan
        $uangDiberikan = (int) preg_replace('/[^0-9]/', '', $request->input('uang_diberikan'));
        if ($uangDiberikan < $total) {
            return redirect()->back()->with('error', 'Uang yang diberikan kurang!');
        }

        // Generate nomor invoice unik, contoh:
        $invoice = 'INV-' . date('YmdHis');

        DB::beginTransaction();

        try {
            // Simpan ke tabel order
            $orders = Order::create([
                'invoice' => $invoice,
                'total' => $total,
                'id_user' => Auth::id(),
            ]);

            // Simpan detail order
            foreach ($keranjang as $id_produk => $item) {
                if (empty($id_produk) || !is_numeric($id_produk)) {
                    continue; // atau log error
                }

                OrderDetail::create([
                    'order_id' => $orders->order_id,
                    'id_produk' => (int)$id_produk,
                    'harga' => $item['harga'],
                    'jumlah' => $item['jumlah'],
                ]);

                //stok berkurang jika membeli
                $produk = \App\Models\produk::find($id_produk);
                if ($produk) {
                    $produk->stok = max(0, $produk->stok - $item['jumlah']);
                    $produk->save();
                }
            }


            DB::commit();

            // Kosongkan keranjang
            $request->session()->forget('keranjang');

            // Redirect ke halaman utama
            return redirect('/kasir')->with('success', 'Transaksi berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
