<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporta - Profil Saya</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0F4C81, #1565C0, #00B8D9); }
        .glass { backdrop-filter: blur(16px); }
    </style>
</head>
<body class="min-h-screen py-10 px-4 relative">
    <!-- Background Wrapper Gedung + Overlay Biru -->
    <div class="fixed inset-0 -z-30">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0F4C81]/85 backdrop-blur-[2px]"></div>
    </div>

    <div class="max-w-3xl mx-auto space-y-6">
        
        <!-- Top Header Navigation (Glassmorphism White/95) -->
        <div class="bg-white/95 glass border border-white/20 p-6 rounded-[2rem] shadow-2xl flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 hero-gradient rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">Reporta</h1>
                    <p class="text-slate-500 text-xs">Menu: <span class="text-[#0F4C81] font-bold">Profile Settings</span></p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                    <a href="{{ route('laporan.dashboard') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02] whitespace-nowrap">Dashboard Admin</a>
                @else
                    <a href="{{ route('laporan.index') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02] whitespace-nowrap">Back</a>
                @endif
            </div>
        </div>

        <!-- Judul Halaman -->
        <div class="space-y-1 pl-4">
            <h2 class="text-2xl font-extrabold text-white drop-shadow-md">Account Settings</h2>
            <p class="text-slate-200 text-xs font-medium">Manage your personal information and the security of your system access credentials.</p>
        </div>

        <!-- Status Sessions (Success / Errors) -->
        @if(session('success_profile'))
            <div class="bg-emerald-500/10 backdrop-blur-md border border-emerald-500/30 p-5 rounded-2xl shadow-xl">
                <p class="font-bold text-emerald-600 text-sm">{{ session('success_profile') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-rose-500/10 backdrop-blur-md border border-rose-500/20 text-rose-600 p-5 rounded-2xl shadow-xl text-xs space-y-1 font-bold">
                @foreach($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Main Content Area -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
            
            <!-- Kiri: Informasi Identitas (Glassmorphism White/95) -->
            <div class="md:col-span-5 bg-white/95 glass border border-white/20 rounded-[2rem] shadow-2xl p-6 space-y-4">
                <div class="border-b border-slate-100 pb-3">
                    <span class="text-[10px] font-extrabold text-[#0F4C81] uppercase tracking-[0.15em] block mb-1">Identity</span>
                    <h3 class="text-sm font-extrabold text-slate-800">Basic Informations</h3>
                </div>
                
                <div class="space-y-3">
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl">
                        <span class="text-[10px] font-extrabold text-[#0F4C81] uppercase tracking-wider block mb-1">Email Address</span>
                        <span class="text-sm font-bold text-slate-800 font-mono break-all block">{{ $user->email }}</span>
                        <span class="text-[10px] text-slate-400 mt-1 block font-normal">*Your email address cannot be changed.</span>
                    </div>
                    
                    <div class="bg-slate-50 border border-slate-100 p-4 rounded-2xl flex justify-between items-center">
                        <div>
                            <span class="text-[10px] font-extrabold text-[#0F4C81] uppercase tracking-wider block mb-1">Access Rights</span>
                            <span class="text-sm font-bold text-slate-800 block">
                                {{ $user->role === 'superadmin' ? 'Super Admin' : ($user->role === 'admin_instansi' ? 'Admin Instansi' : 'Citizen') }}
                            </span>
                        </div>
                        <span class="px-2.5 py-1 bg-blue-100 text-[#0F4C81] text-[10px] font-black tracking-wide uppercase rounded-lg">
                            Verified
                        </span>
                    </div>
                </div>
            </div>

            <!-- Kanan: Form Perubahan Data (Glassmorphism White/95) -->
            <div class="md:col-span-7 bg-white/95 glass border border-white/20 rounded-[2rem] shadow-2xl p-6 md:p-8">
                <div class="border-b border-slate-100 pb-3 mb-6">
                    <span class="text-[10px] font-extrabold text-[#0F4C81] uppercase tracking-[0.15em] block mb-1">Credentials</span>
                    <h3 class="text-sm font-extrabold text-slate-800">Update Profile & Password</h3>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-5">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2 tracking-[0.1em]">Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2 tracking-[0.1em]">Current Password <span class="text-rose-500">*</span></label>
                        <input type="password" name="current_password" required placeholder="Enter your current password"
                               class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium transition-all font-mono">
                    </div>

                    <div class="border-t border-slate-100 my-2 pt-3">
                        <p class="text-[11px] text-slate-400 font-normal">Current Password.</p>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2 tracking-[0.1em]">New Password (Optional)</label>
                        <input type="password" name="password" placeholder="Minimal 6 karakter"
                               class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium transition-all font-mono">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2 tracking-[0.1em]">Confirm New Password</label>
                        <input type="password" name="password_confirmation" placeholder="Enter your new password"
                               class="w-full px-5 py-3.5 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium transition-all font-mono">
                    </div>
                    
                    <div class="pt-2">
                        <button type="submit" class="w-full hero-gradient text-white font-bold py-4 rounded-2xl hover:scale-[1.01] transition-all duration-300 text-sm shadow-xl shadow-blue-500/20 cursor-pointer">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
            
        </div>

        <!-- Footer -->
        <footer class="text-center text-[11px] text-slate-300 py-4 border-t border-white/10 font-medium tracking-wide">
            &copy; 2026 SmartCity Informatics Platform. All Rights Reserved.
        </footer>
    </div>
</body>
</html>