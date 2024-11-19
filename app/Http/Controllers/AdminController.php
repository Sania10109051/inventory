<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Pastikan untuk menambahkan ini

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function kelola_user()
    {
        $users = User::all();

        return view('admin.kelola_user', compact('users'));
    }

    public function create()
    {
        return view('admin.add_user');
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'id_pegawai' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'level_akses' => 'required|string|max:50',
        ]);

        User::create($request->all());

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function kelola_inventaris()
    {
        return view('admin.kelola_inventaris');
    }
}
