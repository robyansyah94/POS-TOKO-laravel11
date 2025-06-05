<?php

namespace App\Http\Controllers;

use App\Models\OrderDetail;
use Illuminate\Http\Request;

class DTransaksiController extends Controller
{
    //TAMPILAN
    public function index()
    {
        $data['result'] = \App\Models\OrderDetail::all();
        return view('Transaksi/detail')->with($data);
    }
}
