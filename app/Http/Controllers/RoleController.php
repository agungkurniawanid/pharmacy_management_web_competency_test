<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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

    // Load relasi 'role' dan 'pelanggan' sekaligus untuk menghemat query
    $user = User::with(['role', 'pelanggan'])->where('email', $validated['email'])->first();

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
        // TAMBAHAN PENTING: Cek jika dia punya profil pelanggan, simpan kodenya.
        'kode_pelanggan' => $user->pelanggan ? $user->pelanggan->kode_pelanggan : null,
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
    
    return redirect()->route('dashboard.obat.index')
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
    public function index(Request $request)
    {
        $query = User::with('role');

        // 1. Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 2. Filter Role
        if ($request->filled('role')) {
            $query->where('role_id', $request->role);
        }

        // 3. Sorting
        switch ($request->get('sort', 'newest')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            default: // newest
                $query->latest('created_at');
                break;
        }

        $users = $query->paginate(10)->withQueryString();
        $roles = Role::all();

        // Stats
        $totalPengguna = User::count();
        // Asumsi Role 1 = Pemilik/Manajer, Role 2 = Admin Gudang, Role 3 = Kasir
        $totalPemilik = User::where('role_id', 1)->count();
        $totalGudang = User::where('role_id', 2)->count();
        $totalKasir = User::where('role_id', 3)->count();

        return view('pages.access.index', compact(
            'users', 'roles', 'totalPengguna', 'totalPemilik', 'totalGudang', 'totalKasir'
        ))->with('title', 'Dashboard | Users Management & Access');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
            // Field khusus pelanggan
            'alamat'   => 'nullable|string',
            'kota'     => 'nullable|string|max:50',
            'telpon'   => 'nullable|string|max:13',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Buat User Login
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $request->role_id,
            ]);

            // 2. Cek apakah Role adalah Pelanggan (Asumsi string ada kata 'pelanggan')
            $role = Role::find($request->role_id);
            if (str_contains(strtolower($role->nama_role), 'pelanggan')) {
                
                $lastCust = Pelanggan::orderBy('kode_pelanggan', 'desc')->first();
                $nextNum = $lastCust ? ((int) substr($lastCust->kode_pelanggan, 4)) + 1 : 1;
                $kodeCust = 'PEL-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

                // Buat Profil Pelanggan dan tautkan user_id
                Pelanggan::create([
                    'kode_pelanggan' => $kodeCust,
                    'user_id'        => $user->id,
                    'nama_pelanggan' => $user->name,
                    'alamat'         => $request->alamat,
                    'kota'           => $request->kota,
                    'telpon'         => $request->telpon,
                ]);
            }
        });

        return redirect()->route('dashboard.access.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role_id'  => 'required|exists:roles,id',
            // Password opsional saat update
            'password' => 'nullable|string|min:6',
        ]);

        DB::transaction(function () use ($request, $user) {
            // 1. Siapkan data update User
            $userData = [
                'name'    => $request->name,
                'email'   => $request->email,
                'role_id' => $request->role_id,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            // 2. Sinkronkan nama ke tabel pelanggan jika user ini adalah pelanggan
            $pelanggan = Pelanggan::where('user_id', $user->id)->first();
            if ($pelanggan) {
                $pelanggan->update(['nama_pelanggan' => $request->name]);
            }
        });

        return redirect()->route('dashboard.access.index')->with('success', 'Data pengguna berhasil diperbarui');
    }

    public function destroy(string $id)
    {
        // Cegah user menghapus dirinya sendiri
        if (Auth::id() == $id) {
            return redirect()->route('dashboard.access.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        $user = User::findOrFail($id);

        DB::transaction(function () use ($user) {
            // Karena tabel pelanggans di-set nullOnDelete() untuk foreign key user_id,
            // kita cukup menghapus user-nya saja. Profil pelanggan di tabel pelanggans 
            // akan otomatis terputus (user_id jadi null) namun historinya tetap ada.
            $user->delete();
        });

        return redirect()->route('dashboard.access.index')->with('success', 'Pengguna berhasil dihapus');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
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

    public function signupView()
    {
        return view('pages.auth.signup', [
            'title' => 'Daftar Akun Pelanggan',
        ]);
    }

    /**
     * Handle signup functionality
     */
    public function signupFunction(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6',
            'telpon'                => 'nullable|string|max:13',
            'alamat'                => 'nullable|string',
            'kota'                  => 'nullable|string|max:50',
        ]);

        DB::transaction(function () use ($request) {
            // 1. Cari Role ID untuk "Pelanggan"
            $rolePelanggan = Role::where('nama_role', 'LIKE', '%pelanggan%')->first();
            
            if (!$rolePelanggan) {
                throw new \Exception('Role Pelanggan tidak ditemukan! Pastikan role sudah ada di database.');
            }

            // 2. Buat User Login
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role_id'  => $rolePelanggan->id,
            ]);

            // 3. Generate Kode Pelanggan Otomatis
            $lastCust = Pelanggan::orderBy('kode_pelanggan', 'desc')->first();
            $nextNum = $lastCust ? ((int) substr($lastCust->kode_pelanggan, 4)) + 1 : 1;
            $kodeCust = 'PEL-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            // 4. Buat Profil Pelanggan
            Pelanggan::create([
                'kode_pelanggan' => $kodeCust,
                'user_id'        => $user->id,
                'nama_pelanggan' => $request->name,
                'alamat'         => $request->alamat,
                'kota'           => $request->kota,
                'telpon'         => $request->telpon,
            ]);
        });

        return redirect()->route('login')
            ->with('success', 'Pendaftaran berhasil! Silakan login dengan akun Anda.');
    }
}
