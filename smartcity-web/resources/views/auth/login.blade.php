<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Reporta Public Reporting System</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0F4C81, #1565C0, #00B8D9); }
        .fade-in { animation: fadeIn 0.8s ease-out; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(15px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="fixed inset-0 -z-30">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0F4C81]/85 backdrop-blur-[2px]"></div>
    </div>

    <div class="max-w-md w-full bg-white/95 backdrop-blur-xl border border-white/20 p-8 md:p-10 rounded-[2.5rem] shadow-2xl fade-in space-y-8">
        
        <div class="text-center space-y-2">
            <div class="w-16 h-16 hero-gradient rounded-3xl flex items-center justify-center mx-auto shadow-lg shadow-blue-500/20">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>
                </svg>
            </div>
            <h2 class="text-2xl font-extrabold text-slate-800">Selamat Datang</h2>
            <p class="text-sm text-slate-500">Gunakan kredensial Anda untuk masuk ke sistem.</p>
        </div>

        @if(session('success_reg'))
            <div class="bg-emerald-50 text-emerald-700 p-4 text-xs font-semibold rounded-2xl border border-emerald-100">
                {{ session('success_reg') }}
            </div>
        @endif

        @if($errors->has('login_error'))
            <div class="bg-rose-50 text-rose-700 p-4 text-xs font-semibold rounded-2xl border border-rose-100">
                {{ $errors->first('login_error') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Alamat Email</label>
                <input type="email" name="email" required placeholder="nama@email.com" 
                       class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:border-[#0F4C81] focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 transition-all duration-300">
            </div>
            <div>
                <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Password</label>
                <input type="password" name="password" required placeholder="••••••••" 
                       class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:border-[#0F4C81] focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 transition-all duration-300">
            </div>
            
            <button type="submit" class="w-full hero-gradient hover:scale-[1.02] hover:shadow-xl hover:shadow-blue-500/30 text-white font-bold py-4 rounded-2xl transition-all duration-300 text-sm cursor-pointer mt-2">
                Masuk Sekarang 
            </button>
        </form>

        <div class="space-y-4 pt-4 text-center border-t border-slate-100">
            <p class="text-sm text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[#0F4C81] font-bold hover:underline">Daftar di sini</a>
            </p>
            <a href="{{ route('landing') }}" class="inline-flex items-center text-xs text-slate-400 hover:text-slate-600 transition-colors gap-1">
                &larr; Kembali ke Beranda
            </a>
        </div>
    </div>

</body>
</html>