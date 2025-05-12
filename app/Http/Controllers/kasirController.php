<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class kasirController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\produk::all();
        return view('Kasir/index')->with($data);
    }
}
