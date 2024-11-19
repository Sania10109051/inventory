<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KelolaUsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.kelola_user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.kelola_user.add');
    }

    public function store(Request $request)
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
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->department = $request->department;

        $gambar = $request->file('profile_image');

        if ($gambar) {
            $gambar->move('profileImages', $gambar->getClientOriginalName());
            $user->profile_image = $gambar->getClientOriginalName();
        }

        $user->save();

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('admin.kelola_user.edit', compact('user'));
    }

    public function update(Request $request, $id)
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
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->department = $request->department;

        $gambar = $request->file('profile_image');

        if ($gambar) {
            $gambar->move('profileImages', $gambar->getClientOriginalName());
            $user->profile_image = $gambar->getClientOriginalName();
        }

        $user->save();

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil diubah');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('kelola_user.index')->with('success', 'User berhasil dihapus');
    }


}
