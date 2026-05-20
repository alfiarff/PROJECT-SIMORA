<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Resep;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $users      = User::orderBy('role')->get();
        $totalUsers = User::count();
        $onlineUsers = User::where('last_seen', '>=', Carbon::now()->subMinutes(5))->count();
        $totalPasien = Pasien::count();
        $totalResep  = Resep::count();

        $roleCount = [
            'admin'    => User::where('role', 'admin')->count(),
            'dokter'   => User::where('role', 'dokter')->count(),
            'apoteker' => User::where('role', 'apoteker')->count(),
            'pmik'     => User::where('role', 'pmik')->count(),
        ];

        return view('admin.dashboard', compact(
            'users', 'totalUsers', 'onlineUsers',
            'totalPasien', 'totalResep', 'roleCount'
        ));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,dokter,apoteker,pmik'
        ]);

        $user = User::findOrFail($id);
        $user->update(['role' => $request->role]);

        return redirect()->back()->with('success', "Role {$user->name} berhasil diubah menjadi {$request->role}.");
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', "Akun {$user->name} berhasil dihapus.");
    }

    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:6|confirmed'
        ]);

        $user = User::findOrFail($id);
        $user->update(['password' => Hash::make($request->new_password)]);

        return redirect()->back()->with('success', "Password {$user->name} berhasil direset.");
    }
}