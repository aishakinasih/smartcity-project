<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport - Report History </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0F4C81, #1565C0, #00B8D9); }
        .glass { backdrop-filter: blur(16px); }
    </style>
</head>
<body class="min-h-screen py-10 px-4 relative">
    <!-- Background Gedung + Overlay Biru (Sama persis dengan halaman laporan) -->
    <div class="fixed inset-0 -z-30">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0F4C81]/85 backdrop-blur-[2px]"></div>
    </div>

    <div class="max-w-4xl mx-auto space-y-6">
        
        <!-- Top Header Navigation (Gaya Glassmorphism Putih) -->
        <div class="bg-white/95 glass border border-white/20 p-6 rounded-[2rem] shadow-2xl flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 hero-gradient rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">My Report History</h1>
                    <p class="text-slate-500 text-xs">Welcome Back, <span class="text-[#0F4C81] font-bold">{{ auth()->user()->name }}</span></p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('laporan.index') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02] whitespace-nowrap">Create a New Report</a>
                <a href="{{ route('profile.show') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02] whitespace-nowrap">My Profile</a>
                <form id="riwayat-logout-form" action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02] whitespace-nowrap cursor-pointer">Log Out</button>
                </form>
            </div>
        </div>

        <!-- Container Tabel (Gaya Card Form Laporan Putih Bulat) -->
        <div class="bg-white/95 glass border border-white/20 p-8 md:p-10 rounded-[2.5rem] shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse min-w-[750px]">
                    <thead>
                        <tr class="bg-slate-50 text-[#0F4C81] text-xs font-extrabold uppercase border-b border-slate-100 tracking-[0.1em]">
                            <th class="px-6 py-4 rounded-tl-2xl w-[35%]">Your Reports</th>
                            <th class="px-6 py-4 w-[30%]">Assigned Agency</th>
                            <th class="px-6 py-4 w-[15%]">Locations</th>
                            <th class="px-6 py-4 text-center rounded-tr-2xl w-[20%]">Progress Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-800 font-medium">
                        @forelse($laporans as $laporan)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            
                            <!-- Detail Keluhan -->
                            <td class="px-6 py-5">
                                <div class="font-bold text-slate-800 group-hover:text-[#1565C0] transition-colors mb-1 text-base">
                                    {{ $laporan->judul ?: '-' }}
                                </div>
                                <p class="text-slate-500 text-xs leading-relaxed max-w-sm break-words font-normal">
                                    {{ $laporan->isi_laporan ?: '-' }}
                                </p>
                                <span class="text-[10px] text-slate-400 font-bold block mt-3 tracking-wide">
                                    {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : 'Tanggal tidak tersedia' }} WIB
                                </span>
                            </td>
                            
                            <!-- Nama Instansi -->
                            <td class="px-6 py-5 vertical-align-middle">
                                <span class="inline-block px-3 py-1.5 bg-slate-50 border border-slate-100 rounded-xl text-slate-700 font-bold text-xs tracking-wide uppercase max-w-xs break-words whitespace-normal shadow-xs">
                                    {{ $laporan->instansi }}
                                </span>
                            </td>
                            
                            <!-- Lokasi Kejadian -->
                            <td class="px-6 py-5 text-slate-600 text-xs font-semibold capitalize">
                                {{ $laporan->lokasi ?: '-' }}
                            </td>
                            
                            <!-- Status Dinamis -->
                            <td class="px-6 py-5 text-center">
                                @if($laporan->status == 'Masuk')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-slate-100 border border-slate-200 text-slate-600 text-xs font-extrabold rounded-full shadow-xs">
                                        Laporan Masuk
                                    </span>
                                @elseif($laporan->status == 'Diproses')
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-rose-50 border border-rose-100 text-rose-600 text-xs font-extrabold rounded-full shadow-xs">
                                        Sedang Diproses
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-extrabold rounded-full shadow-xs">
                                        Selesai Ditangani
                                    </span>
                                @endif
                            </td>
                            
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-16 text-center text-slate-400 italic font-medium">
                                You have not submitted any reports yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>