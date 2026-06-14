<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport AI - Profil Saya</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#090e1a] text-slate-100 font-sans antialiased min-h-screen">

    <div class="max-w-3xl mx-auto p-4 md:p-6 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-[#030712] py-3 px-5 rounded-2xl border border-slate-800/70 shadow-xl">
            <div>
                <h1 class="text-lg font-bold tracking-tight bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                    SmartReport AI
                </h1>
                <p class="text-slate-400 text-[11px] mt-0.5">
                    Menu: <span class="text-slate-200 font-semibold">Pengaturan Profil</span>
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                    <a href="{{ route('laporan.dashboard') }}" class="h-9 px-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                        <span class="whitespace-nowrap"> Dashboard Admin</span>
                    </a>
                @else
                    <a href="{{ route('laporan.index') }}" class="h-9 px-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                        <span class="whitespace-nowrap"> Form Pengaduan</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="space-y-0.5">
            <h2 class="text-xl font-bold text-slate-100 tracking-tight">Pengaturan Akun</h2>
            <p class="text-xs text-slate-400">Kelola informasi data diri dan keamanan kredensial akun akses sistem Anda.</p>
        </div>

        @if(session('success_profile'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 p-4 rounded-xl text-emerald-400 text-xs">
                {{ session('success_profile') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-500/10 border border-rose-500/20 text-rose-400 p-4 rounded-xl text-xs space-y-1">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <div class="md:col-span-5 bg-[#030712] border border-slate-800/60 rounded-2xl p-5 shadow-xl space-y-4">
                <div class="border-b border-slate-800/60 pb-3">
                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest block mb-0.5">Identitas</span>
                    <h3 class="text-sm font-bold text-slate-100">Informasi Dasar</h3>
                </div>

                <div class="space-y-3">
                    <div class="bg-[#090e1a] border border-slate-800/60 p-3.5 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Alamat Email</span>
                        <span class="text-xs font-semibold text-slate-300 mt-1 block font-mono break-all">{{ $user->email }}</span>
                        <span class="text-[9px] text-slate-500 mt-1 block">*Email tidak dapat diubah.</span>
                    </div>

                    <div class="bg-[#090e1a] border border-slate-800/60 p-3.5 rounded-xl flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Hak Akses</span>
                            <span class="text-xs font-semibold text-slate-300 mt-0.5 block">
                                {{ $user->role === 'superadmin' ? 'Super Admin' : ($user->role === 'admin_instansi' ? 'Admin Instansi' : 'Masyarakat Publik') }}
                            </span>
                        </div>
                        <span class="px-1.5 py-0.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-bold font-mono uppercase rounded-md">
                            Verified
                        </span>
                    </div>
                </div>
            </div>

            <div class="md:col-span-7 bg-[#030712] border border-slate-800/60 rounded-2xl p-5 md:p-6 shadow-xl">
                <div class="border-b border-slate-800/60 pb-3 mb-4">
                    <span class="text-[10px] font-bold text-red-500 uppercase tracking-widest block mb-0.5">Kredensial</span>
                    <h3 class="text-sm font-bold text-slate-100">Perbarui Profil & Kata Sandi</h3>
                </div>

                <form action="{{ route('profile.update') }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                               class="w-full bg-[#090e1a] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Sekarang <span class="text-rose-500">*</span></label>
                        <input type="password" name="current_password" required placeholder="Masukkan kata sandi saat ini"
                               class="w-full bg-[#090e1a] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="border-t border-slate-800/40 my-3 pt-3">
                        <p class="text-[10px] text-slate-400">*Kosongkan kolom di bawah jika tidak ingin mengubah kata sandi.</p>
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Baru (Opsional)</label>
                        <input type="password" name="password" 
                               class="w-full bg-[#090e1a] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" 
                               class="w-full bg-[#090e1a] border border-slate-800 rounded-xl px-4 py-2.5 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold px-5 py-2.5 rounded-xl transition-all text-xs tracking-wide shadow-md shadow-blue-900/20 cursor-pointer">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>

        <footer class="text-center text-[10px] text-slate-600 py-4 border-t border-slate-800/40 font-medium">
            &copy; 2026 SmartCity Informatics Platform. All Rights Reserved.
        </footer>
    </div>

</body>
</html>