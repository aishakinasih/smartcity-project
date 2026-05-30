<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Sistem - SmartReport AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-4xl w-full grid md:grid-cols-2 gap-8 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-slate-100">
        
        <div class="space-y-6 flex flex-col justify-center">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Selamat Datang Kembali</h2>
                <p class="text-sm text-slate-400 mt-1">Silakan masuk menggunakan akun Anda.</p>
            </div>

            @if($errors->has('login_error'))
                <div class="bg-rose-50 text-rose-600 p-3.5 text-xs font-medium rounded-xl border-l-4 border-rose-500">
                    {{ $errors->first('login_error') }}
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Alamat Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition-colors text-sm cursor-pointer">
                    Masuk Sekarang
                </button>
            </form>
            <div class="text-center">
                <a href="{{ route('landing') }}" class="text-xs text-slate-400 hover:underline">&larr; Kembali ke Beranda</a>
            </div>
        </div>

        <div class="space-y-6 flex flex-col justify-center border-t md:border-t-0 md:border-l border-slate-100 pt-8 md:pt-0 md:pl-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Belum Punya Akun?</h2>
                <p class="text-sm text-slate-400 mt-1">Daftarkan diri Anda untuk mengajukan laporan.</p>
            </div>

            @if(session('success_reg'))
                <div class="bg-emerald-50 text-emerald-600 p-3.5 text-xs font-medium rounded-xl border-l-4 border-emerald-500">
                    {{ session('success_reg') }}
                </div>
            @endif

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Nama Anda" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Alamat Email</label>
                    <input type="email" name="email" required placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-semibold uppercase text-slate-500 mb-2">Password Baru</label>
                    <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm">
                </div>
                <button type="submit" class="w-full bg-slate-800 hover:bg-slate-900 text-white font-semibold py-3 rounded-xl shadow-md transition-colors text-sm cursor-pointer">
                    Daftar Akun Baru
                </button>
            </form>
        </div>

    </div>

</body>
</html>