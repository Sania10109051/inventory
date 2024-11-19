<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function show()
    {
        $profile = User::find(Auth::user()->id);

        return view('user.profile', compact('profile'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'foto' => 'nullable|image',
            'department' => 'required',
            'phone' => 'required',
        ]
        , [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Email tidak valid.',
            'foto.image' => 'File yang diupload harus berupa gambar.',
            'department.required' => 'Departemen harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
        ]);

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->phone = $request->phone;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $foto->move('profileImages', $foto->getClientOriginalName());
            $user->profile_image = $foto->getClientOriginalName();
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]
        , [
            'old_password.required' => 'Password lama harus diisi.',
            'password.required' => 'Password baru harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        $user = User::find(Auth::user()->id);

        if (password_verify($request->old_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->back()->with('success', 'Password berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Password lama salah.');
    }
}
