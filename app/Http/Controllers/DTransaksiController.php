<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DTransaksiController extends Controller
{
    public function detail($order_id)
    {
        $details = \App\Models\OrderDetail::with('produk')
            ->where('order_id', $order_id)
            ->get();

        if ($details->isEmpty()) {
            return response()->json(['html' => '<p>Data detail tidak ditemukan.</p>']);
        }

        // Render view partial untuk isi modal
        $html = view('transaksi.detail_modal', compact('details'))->render();

        return response()->json(['html' => $html]);
    }
}
