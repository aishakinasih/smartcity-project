<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport AI - Profil Saya</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-950 to-slate-900 text-slate-100 min-h-screen flex flex-col justify-between antialiased">

    <header class="max-w-7xl w-full mx-auto px-8 py-5 flex justify-between items-center border-b border-slate-800/40 backdrop-blur-sm sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <span class="text-lg font-black text-blue-400 tracking-wider">SmartReport AI</span>
            <span class="text-xs bg-slate-800 text-slate-400 px-2 py-0.5 rounded-md font-mono border border-slate-700/50">Profil Pengguna</span>
        </div>
        
        <div class="flex items-center gap-4">
            @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                <a href="{{ route('laporan.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 font-medium transition-all">
                    &larr; Kembali ke Dashboard Admin
                </a>
            @else
                <a href="{{ route('laporan.index') }}" class="text-xs text-slate-400 hover:text-slate-200 font-medium transition-all">
                    &larr; Kembali ke Form Pengaduan
                </a>
            @endif
        </div>
    </header>

    <main class="max-w-5xl w-full mx-auto px-6 py-12 flex-1 space-y-8">
        
        <div class="space-y-1">
            <h2 class="text-2xl font-extrabold text-slate-100 tracking-tight">Pengaturan Akun</h2>
            <p class="text-xs text-slate-400">Kelola informasi data diri dan keamanan kredensial akun akses sistem Anda.</p>
        </div>

        @if(session('success_profile'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 p-4 rounded-xl text-xs">
                {{ session('success_profile') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-slate-950/40 border border-slate-800/60 rounded-3xl p-6 shadow-xl backdrop-blur-md space-y-6">
                    <div class="border-b border-slate-800/60 pb-4 text-center lg:text-left">
                        <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest block mb-1">Identitas</span>
                        <h3 class="text-lg font-bold text-slate-100">Informasi Dasar</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="bg-slate-900/40 border border-slate-800/40 p-4 rounded-xl">
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Alamat Email</span>
                            <span class="text-sm font-semibold text-slate-400 mt-1 block font-mono">{{ $user->email }}</span>
                            <span class="text-[9px] text-slate-500 mt-1 block">*Email tidak dapat diubah demi keamanan.</span>
                        </div>

                        <div class="bg-slate-900/40 border border-slate-800/40 p-4 rounded-xl flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Hak Akses Sistem</span>
                                <span class="text-xs font-semibold text-slate-300 mt-0.5 block">
                                    {{ $user->role === 'superadmin' ? 'Super Admin' : ($user->role === 'admin_instansi' ? 'Admin Instansi ('.$user->instansi.')' : 'Masyarakat Publik') }}
                                </span>
                            </div>
                            <span class="px-2 py-0.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-bold font-mono uppercase rounded-md tracking-wider">
                                Verified
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-red-950/10 border border-red-900/30 rounded-3xl p-6 shadow-xl backdrop-blur-md space-y-4">
                    <div>
                        <h4 class="text-sm font-bold text-red-400">Zona Bahaya</h4>
                        <p class="text-[11px] text-slate-400 mt-1">Setelah Anda menghapus akun, semua data laporan dan informasi Anda akan dihapus secara permanen.</p>
                    </div>
                    <form action="{{ route('profile.delete') }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini secara permanen? Tindakan ini tidak dapat dibatalkan.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full bg-red-600/20 hover:bg-red-600 border border-red-500/30 hover:border-red-600 text-red-200 hover:text-white font-semibold px-4 py-2.5 rounded-xl transition-all text-xs tracking-wide">
                            Hapus Akun Permanen
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-7 bg-slate-950/40 border border-slate-800/60 rounded-3xl p-6 md:p-8 shadow-xl backdrop-blur-md">
                <div class="border-b border-slate-800/60 pb-4 mb-6">
                    <span class="text-[10px] font-bold text-amber-500 uppercase tracking-widest block mb-1">Kredensial</span>
                    <h3 class="text-lg font-bold text-slate-100">Perbarui Profil & Kata Sandi</h3>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Sekarang <span class="text-red-500">*</span></label>
                        <input type="password" name="current_password" required placeholder="Masukkan kata sandi saat ini untuk konfirmasi"
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="border-t border-slate-800/40 my-4 pt-4">
                        <p class="text-[10px] text-slate-400 mb-3">*Kosongkan kolom di bawah jika tidak ingin mengubah kata sandi.</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Baru (Opsional)</label>
                        <input type="password" name="password" 
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" 
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-xl transition-all text-xs tracking-wide shadow-md shadow-blue-900/10">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </main>

    <footer class="text-center text-[11px] text-slate-600 py-6 border-t border-slate-800/40 bg-slate-950/20 font-medium">
        &copy; 2026 SmartCity Informatics Platform. All Rights Reserved.
    </footer>

</body>
</html>