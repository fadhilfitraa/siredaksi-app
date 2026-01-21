<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Tampilkan Daftar Admin
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    // Tampilkan Form Tambah Admin
    public function create()
    {
        return view('user.create');
    }

    // Proses Simpan Admin Baru
    public function store(Request\Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('user.index')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    // Fitur Hapus Admin (Penting jika ada staff resign)
    public function destroy($id)
    {
        // Cegah hapus diri sendiri (opsional tapi disarankan)
        if (auth()->user()->id == $id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'Akun berhasil dihapus.');
    }
}