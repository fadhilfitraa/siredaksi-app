<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; // Import ini sudah benar
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
    // PERBAIKAN: Hapus '\Request' yang berlebihan
    public function store(Request $request)
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

    // Fitur Hapus Admin
    public function destroy($id)
    {
        // Cegah hapus diri sendiri
        if (auth()->user()->id == $id) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        User::findOrFail($id)->delete();
        return redirect()->route('user.index')->with('success', 'Akun berhasil dihapus.');
    }
}