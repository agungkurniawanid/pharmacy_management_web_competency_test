{{-- 
    Cara mengakses data user dan role dari session di Dashboard atau View manapun:
    
    1. Akses data user:
       - {{ session('user')['name'] }} - Mendapatkan nama user
       - {{ session('user')['email'] }} - Mendapatkan email user
       - {{ session('user')['id'] }} - Mendapatkan ID user
       - {{ session('user')['role_id'] }} - Mendapatkan role_id user

    2. Akses data role:
       - {{ session('user_role')['nama_role'] }} - Mendapatkan nama role
       - {{ session('user_role')['keterangan'] }} - Mendapatkan keterangan role
       - {{ session('user_role')['id'] }} - Mendapatkan ID role

    3. Check apakah user sudah login:
       - @if(Auth::check()) ... @endif

    4. Check role user:
       - @if(session('user_role')['nama_role'] === 'Admin') ... @endif

    5. Di Controller atau logic:
       - $user = session('user');
       - $role = session('user_role');
       - $userFromAuth = Auth::user(); // Mendapatkan user dari authentication guard

    Contoh penggunaan di Dashboard:
--}}

<div class="space-y-4 mb-8">
    <h2 class="text-2xl font-bold text-white">Selamat datang, {{ session('user')['name'] }}!</h2>
    <p class="text-slate-400">
        Role: <span class="text-blue-400 font-semibold">{{ session('user_role')['nama_role'] ?? 'N/A' }}</span>
    </p>
    <p class="text-slate-400">
        Email: {{ session('user')['email'] }}
    </p>
</div>

{{-- Session Flow Diagram --}}
{{--
    LOGIN FLOW:
    1. User mengisikan email & password → POST /login
    2. RoleController::loginFunction() memvalidasi credentials
    3. Jika valid:
       a. Auth::login($user) - User authenticated
       b. session()->put('user', $userData) - Store user data
       c. session()->put('user_role', $roleData) - Store role data
       d. Redirect ke dashboard dengan success notification
    4. Di Dashboard, akses data via session('user') dan session('user_role')
    5. Logout → POST /logout mengubah session

    LOGOUT FLOW:
    1. User klik logout → POST /logout
    2. RoleController::logout() dijalankan
    3. Auth::logout() - Clear authentication
    4. $request->session()->invalidate() - Clear semua session
    5. $request->session()->regenerateToken() - Refresh CSRF token
    6. Redirect ke login dengan success notification
--}}
