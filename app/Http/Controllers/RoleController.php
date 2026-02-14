<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RoleController extends Controller
{
    /**
     * Display login form
     */
    public function loginView()
    {
        return view('auth.login', [
            'title' => 'Login',
        ]);
    }

    /**
     * Handle login functionality
     */
    public function loginFunction(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return redirect()->route('login')
                ->with('error', 'Email atau password salah!');
        }

        // Authenticate user
        Auth::login($user);

        // Store user data in session
        $userData = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => $user->role_id,
        ];

        // Store role data in session
        $roleData = $user->role ? [
            'id' => $user->role->id,
            'nama_role' => $user->role->nama_role,
            'keterangan' => $user->role->keterangan,
        ] : null;

        $request->session()->put('user', $userData);
        $request->session()->put('user_role', $roleData);
        $request->session()->regenerate();

        return redirect()->route('dashboard.index')
            ->with('success', 'Login berhasil! Selamat datang ' . $user->name);
    }

    /**
     * Handle logout functionality
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')
            ->with('success', 'Anda berhasil logout');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.access.index', [
            'title' => 'Dashboard | Users Management & Access',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
