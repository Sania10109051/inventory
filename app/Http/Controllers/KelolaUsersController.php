<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelolaUsersController extends Controller
{
    public function index() // Menampilkan data user
    {
        $users = User::all(); // Mengambil semua data user
        return view('admin.kelola_user.index', compact('users')); // Menampilkan data user
    }

    public function create() // Menampilkan form tambah user
    {
        return view('admin.kelola_user.add'); // Menampilkan form tambah user
    }

    public function store(Request $request) // Menyimpan data user
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'phone' => 'required',
            'department' => 'required',
        ],
        [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'role.required' => 'Role harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'department.required' => 'Departemen harus diisi.',
        ]); // Validasi inputan

        $user = new User(); // Menambahkan model User
        $user->name = $request->name; // Menambahkan data nama dari form
        $user->email = $request->email; // Menambahkan data email dari form
        $user->password = bcrypt($request->password); // Menambahkan data password dari form
        $user->role = $request->role; // Menambahkan data role dari form
        $user->phone = $request->phone; // Menambahkan data phone dari form
        $user->department = $request->department; // Menambahkan data department dari form

        $gambar = $request->file('profile_image'); // Menambahkan data profile_image dari form

        if ($gambar) {  // Jika ada gambar  
            $gambar->move('profileImages', $gambar->getClientOriginalName()); // Pindahkan gambar ke folder profileImages
            $user->profile_image = $gambar->getClientOriginalName(); // Menambahkan data profile_image dari form
        }

        $user->save();  // Menyimpan data user

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil ditambahkan'); // Redirect ke route kelola_user.index
    }

    public function edit($id) // Menampilkan form edit user
    {
        $user = User::find($id); // Mengambil data user berdasarkan id
        return view('admin.kelola_user.edit', compact('user')); // Menampilkan form edit user
    }

    public function update(Request $request, $id) // Mengubah data user
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'phone' => 'required',
            'department' => 'required',
        ],
        [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'role.required' => 'Role harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'department.required' => 'Departemen harus diisi.',
        ]); // Validasi inputan

        $user = User::find($id); // Mengambil data user dari model user berdasarkan id
        $user->name = $request->name; // Mengubah data nama dari form
        $user->email = $request->email; // Mengubah data email dari form
        $user->role = $request->role;       // Mengubah data role dari form
        $user->phone = $request->phone; // Mengubah data phone dari form
        $user->department = $request->department;    // Mengubah data department dari form

        $gambar = $request->file('profile_image'); // Mengambil data profile_image dari form

        if ($gambar) {
            $gambar->move('profileImages', $gambar->getClientOriginalName()); // Pindahkan gambar ke folder profileImages
            $user->profile_image = $gambar->getClientOriginalName(); // Mengubah data profile_image dari form
        }

        $user->save(); // Menyimpan data user

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil diubah'); // Redirect ke route kelola_user.index
    }

    public function destroy($id) // Menghapus data user
    {
        $user = User::find($id); // Mengambil data user berdasarkan id
        $user->delete(); // Menghapus data user 

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil dihapus');    // Redirect ke route kelola_user.index
    }


}
