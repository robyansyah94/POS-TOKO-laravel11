<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        $data['result'] = \App\Models\User::all();
        return view('users/index')->with($data);
    }

    public function create()
    {
        return view('users/form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username'  => 'required|max:100',
            'password'  => 'required|max:100'
        ]);

        $input = $request->all();

        $status = \App\Models\User::create($input);

        if ($status) return redirect('/users')->with('success', 'Data berhasil di tambahkan');
        else return redirect('users')->with('error', 'Data gagal di tambahkan');
    }

    public function edit(string $id)
    {
        //
        $data['result'] = \App\Models\User::where('id_user', $id)->first();
        return view('users/form')->with($data);
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'username'  => 'required|max:100',
            'password'  => 'required|max:100'
        ]);

        $input = $request->all();

        $result = \App\Models\User::where('id_user', $id)->first();
        $status = $result->update($input);

        if ($status) return redirect('/users')->with('success', 'Data berhasil di ubah');
        else return redirect('users')->with('error', 'Data gagal di ubah');
    }

    public function destroy(string $id)
    {
        //
        $result = \App\Models\User::where('id_user', $id)->first();
        $status = $result->delete();

        if ($status) return redirect('/users')->with('success', 'Data berhasil di hapus');
        else return redirect('users')->with('error', 'Data gagal di hapus');
    }
}
