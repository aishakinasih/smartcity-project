<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - SmartReport AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#0f172a] text-slate-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-md w-full bg-[#1e293b]/90 border border-slate-700 p-8 md:p-10 rounded-3xl shadow-2xl shadow-black/80 space-y-6">
        
        <div class="text-center space-y-1">
            <span class="text-xs font-black text-blue-400 tracking-widest uppercase">SmartReport AI</span>
            <h2 class="text-2xl font-extrabold tracking-tight text-white mt-1">Belum Punya Akun?</h2>
            <p class="text-sm text-slate-400">Daftarkan diri Anda untuk mengajukan laporan.</p>
        </div>

        <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-2 tracking-wider">Nama Lengkap</label>
                <input type="text" name="name" required placeholder="Nama Lengkap Anda" 
                       class="w-full px-4 py-3 bg-[#0f172a] border border-slate-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm text-white placeholder:text-slate-500 transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-2 tracking-wider">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" 
                       class="w-full px-4 py-3 bg-[#0f172a] border border-slate-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm text-white placeholder:text-slate-500 transition-all">
            </div>
            <div>
                <label class="block text-xs font-bold uppercase text-slate-300 mb-2 tracking-wider">Password Baru</label>
                <input type="password" name="password" required placeholder="Minimal 6 karakter" 
                       class="w-full px-4 py-3 bg-[#0f172a] border border-slate-600 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-sm text-white placeholder:text-slate-500 transition-all">
            </div>
            
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:shadow-blue-500/30 text-sm cursor-pointer mt-2">
                Daftar Akun Baru
            </button>
        </form>

        <div class="space-y-3 pt-4 text-center border-t border-slate-700/60">
            <p class="text-sm text-slate-400">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-blue-400 font-bold hover:text-blue-300 transition-colors hover:underline">Masuk di sini</a>
            </p>
            <div>
                <a href="{{ route('landing') }}" class="inline-block text-xs text-slate-500 hover:text-slate-400 transition-colors hover:underline">&larr; Kembali ke Beranda</a>
            </div>
        </div>

    </div>

</body>
</html>