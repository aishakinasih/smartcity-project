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
            <a href="{{ route('user.dashboard') }}" class="text-xs text-slate-400 hover:text-slate-200 font-medium transition-all">
                &larr; Kembali ke Dashboard
            </a>
        </div>
    </header>

    <main class="max-w-5xl w-full mx-auto px-6 py-12 flex-1 space-y-8">
        
        <div class="space-y-1">
            <h2 class="text-2xl font-extrabold text-slate-100 tracking-tight">Pengaturan Akun</h2>
            <p class="text-xs text-slate-400">Kelola informasi data diri dan keamanan kredensial akun akses sistem Anda.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <div class="lg:col-span-5 bg-slate-950/40 border border-slate-800/60 rounded-3xl p-6 shadow-xl backdrop-blur-md space-y-6">
                <div class="border-b border-slate-800/60 pb-4 text-center lg:text-left">
                    <span class="text-[10px] font-bold text-blue-500 uppercase tracking-widest block mb-1">Identitas</span>
                    <h3 class="text-lg font-bold text-slate-100">Informasi Dasar</h3>
                </div>

                <div class="space-y-4">
                    <div class="bg-slate-900/40 border border-slate-800/40 p-4 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Nama Lengkap</span>
                        <span class="text-sm font-semibold text-slate-200 mt-1 block">{{ $user->name }}</span>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800/40 p-4 rounded-xl">
                        <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Alamat Email</span>
                        <span class="text-sm font-semibold text-slate-200 mt-1 block font-mono">{{ $user->email }}</span>
                    </div>

                    <div class="bg-slate-900/40 border border-slate-800/40 p-4 rounded-xl flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block">Hak Akses Sistem</span>
                            <span class="text-xs font-semibold text-slate-300 mt-0.5 block">Masyarakat Publik</span>
                        </div>
                        <span class="px-2 py-0.5 bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[9px] font-bold font-mono uppercase rounded-md tracking-wider">
                            Verified
                        </span>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-7 bg-slate-950/40 border border-slate-800/60 rounded-3xl p-6 md:p-8 shadow-xl backdrop-blur-md">
                <div class="border-b border-slate-800/60 pb-4 mb-6">
                    <span class="text-[10px] font-bold text-amber-500 uppercase tracking-widest block mb-1">Kredensial</span>
                    <h3 class="text-lg font-bold text-slate-100">Perbarui Kata Sandi</h3>
                </div>

                <form action="#" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Sekarang</label>
                        <input type="password" name="current_password" required 
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Kata Sandi Baru</label>
                        <input type="password" name="password" required 
                            class="w-full bg-slate-900/60 border border-slate-800 rounded-xl px-4 py-3 text-xs text-slate-200 focus:outline-hidden focus:border-blue-500 transition-all font-mono">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[11px] font-bold text-slate-400 uppercase tracking-wider block">Konfirmasi Kata Sandi Baru</label>
                        <input type="password" name="password_confirmation" required 
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