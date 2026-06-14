<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Prioritas Urgensi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0F4C81, #1565C0, #00B8D9); }
        .glass { backdrop-filter: blur(16px); }
    </style>
</head>
<body class="min-h-screen relative flex">
    <!-- Background Wrapper Gedung + Overlay Biru Utama -->
    <div class="fixed inset-0 -z-30">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0F4C81]/85 backdrop-blur-[2px]"></div>
    </div>

    <!-- SIDEBAR ASLI -->
    <div class="w-64 bg-white/95 glass p-6 flex flex-col justify-between hidden md:flex border-r border-white/20 shrink-0 shadow-2xl z-10 sticky top-0 h-screen">
        <div class="space-y-6">
            <div class="flex flex-col border-b border-slate-100 pb-4">
                <!-- Judul Ujung Kiri: Reporta -->
                <span class="text-xl font-black text-[#0F4C81] tracking-tight">Reporta</span>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                    @if(auth()->user()->role === 'superadmin') Super Admin Panel @else Admin Instansi Panel @endif
                </span>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('laporan.dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all shadow-xs text-xs font-bold uppercase tracking-wide
                    {{ request()->routeIs('laporan.dashboard') ? 'hero-gradient text-white border-transparent' : 'text-slate-500 hover:text-[#0F4C81] hover:bg-slate-50 border-transparent' }}">
                    <span>Antrean Laporan</span>
                </a>
                
                <a href="{{ route('laporan.statistik') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all text-xs font-bold uppercase tracking-wide group
                    {{ request()->routeIs('laporan.statistik') ? 'hero-gradient text-white border-transparent' : 'text-slate-500 hover:text-[#0F4C81] hover:bg-slate-50 border-transparent' }}">
                    <span>Grafik dan Statistik</span>
                </a>
            </nav>
        </div>
        
        <div class="space-y-2">
            <a href="{{ route('profile.show') }}" class="block text-xs text-slate-600 hover:text-[#0F4C81] font-bold uppercase tracking-wide py-2.5 px-4 rounded-xl hover:bg-slate-50 transition-all border border-transparent hover:border-slate-100">
                Pengaturan Profil
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-rose-600 hover:text-rose-700 font-bold uppercase tracking-wide py-2.5 px-4 rounded-xl hover:bg-rose-50 transition-all border border-transparent hover:border-rose-100/50 cursor-pointer">
                    Sistem Keluar
                </button>
            </form>
            <div class="text-[10px] text-slate-400 border-t border-slate-100 pt-4 font-bold uppercase tracking-wider mt-4">IndoBERT Classifier Engine v1.0</div>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- HEADER UTAMA -->
        <header class="bg-white/95 glass border-b border-white/20 px-8 py-4 flex justify-between items-center sticky top-0 z-10 shadow-sm">
            <div>
                @if(auth()->user()->role !== 'superadmin' && auth()->user()->instansi)
                    <span class="text-[10px] font-bold text-[#0F4C81] uppercase tracking-wider block">INSTANSI</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">{{ auth()->user()->instansi }}</h2>
                @else
                    <span class="text-[10px] font-bold text-[#1565C0] uppercase tracking-wider block">KONTROL GLOBAL</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">GLOBAL SUPERADMIN</h2>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-extrabold capitalize tracking-wide">{{ auth()->user()->role }}</p>
                </div>
                <span class="h-6 w-px bg-slate-200 hidden sm:block"></span>
                
                <a href="{{ route('logout') }}"
                    class="px-4 py-2 bg-slate-50 hover:bg-rose-50 border border-slate-200 hover:border-rose-200 text-rose-600 text-xs font-bold rounded-xl transition-all shadow-xs cursor-pointer"
                    onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                    Keluar
                </a>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </header>

        <!-- KONTEN ADUAN -->
        <main class="p-8 space-y-8">
            <!-- TABEL ADUAN UTAMA -->
            <div class="bg-white/95 glass rounded-[2.5rem] border border-white/20 overflow-hidden shadow-2xl p-4 md:p-6">
                <div class="border-b border-slate-100 pb-4 mb-6 pl-2">
                    <h2 class="text-lg font-extrabold text-slate-800 tracking-tight">Antrean Berkas Laporan</h2>
                    <p class="text-slate-400 text-xs">Kelola pembaruan status keluhan dan validasi hasil klasifikasi sistem kecerdasan buatan.</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse min-w-[1100px]">
                        <thead>
                            <tr class="bg-slate-50 text-[#0F4C81] text-xs font-extrabold uppercase border-b border-slate-100 tracking-wider">
                                <th class="px-5 py-4 rounded-tl-2xl">Pelapor</th>
                                <th class="px-5 py-4">Judul Keluhan</th>
                                <th class="px-5 py-4">Isi Laporan</th>
                                @if(auth()->user()->role === 'superadmin')
                                    <th class="px-5 py-4">Instansi</th>
                                @endif
                                <th class="px-5 py-4">Lokasi</th>
                                <th class="px-5 py-4 text-center">Bukti FOTO</th>
                                <th class="px-5 py-4 text-center">Prediksi Urgensi</th>
                                <th class="px-5 py-4 text-center">Conf. Score</th>
                                <th class="px-5 py-4 text-center rounded-tr-2xl w-[180px]">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-800 font-medium">
                            @forelse($laporans as $laporan)
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                
                                <!-- Kolom Pelapor: Menampilkan Nama Akun Asli Pengguna -->
                                <td class="px-5 py-5 vertical-align-top">
                                    <span class="font-bold text-slate-800 block text-sm">
                                        {{ $laporan->user ? $laporan->user->name : 'Anonim' }}
                                    </span>
                                    <span class="text-[10px] text-slate-400 block mt-1 font-semibold">
                                        {{ $laporan->created_at ? $laporan->created_at->format('d/m/Y H:i') : '-' }}
                                    </span>
                                </td>

                                <!-- Kolom Judul Keluhan -->
                                <td class="px-5 py-5 font-bold text-slate-800 group-hover:text-[#1565C0] transition-colors max-w-[180px] break-words vertical-align-top">
                                    {{ $laporan->judul }}
                                </td>

                                <!-- Kolom Isi Laporan Lengkap -->
                                <td class="px-5 py-5 text-slate-500 text-xs font-normal max-w-xs break-words leading-relaxed vertical-align-top">
                                    {{ $laporan->isi_laporan }}
                                </td>
                                
                                <!-- Instansi (Khusus Superadmin) -->
                                @if(auth()->user()->role === 'superadmin')
                                    <td class="px-5 py-5 text-slate-600 text-xs vertical-align-middle">
                                        <span class="px-2.5 py-1.5 bg-slate-50 border border-slate-100 rounded-xl font-bold text-slate-700 tracking-wide block max-w-[200px] truncate uppercase text-[11px]">
                                            {{ $laporan->instansi }}
                                        </span>
                                    </td>
                                @endif
                                
                                <!-- Lokasi -->
                                <td class="px-5 py-5 text-slate-600 font-semibold text-xs capitalize vertical-align-top pt-6">{{ $laporan->lokasi }}</td>
                                
                                <!-- Bukti FOTO -->
                                <td class="px-5 py-5 text-center vertical-align-top pt-5">
                                    @if($laporan->foto)
                                        <a href="{{ asset('uploads/laporan/' . $laporan->foto) }}" target="_blank" class="inline-block group/img">
                                            <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" class="w-14 h-10 object-cover rounded-xl mx-auto border border-slate-200 group-hover/img:scale-105 transition-all shadow-xs" alt="Bukti">
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-400 italic font-normal">Tidak ada foto</span>
                                    @endif
                                </td>
                                
                                <!-- Prediksi Urgensi -->
                                <td class="px-5 py-5 text-center vertical-align-top pt-5">
                                    @if($laporan->urgensi == 'Tinggi')
                                        <span class="px-3 py-1 bg-rose-100 text-rose-700 text-[11px] font-black rounded-full border border-rose-200 shadow-xs">Tinggi</span>
                                    @elseif($laporan->urgensi == 'Sedang')
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 text-[11px] font-black rounded-full border border-amber-200 shadow-xs">Sedang</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 text-[11px] font-black rounded-full border border-emerald-200 shadow-xs">Rendah</span>
                                    @endif
                                </td>
                                
                                <!-- Conf. Score -->
                                <td class="px-5 py-5 text-center font-mono text-xs text-slate-500 font-bold vertical-align-top pt-6">
                                    {{ number_format(($laporan->confidence_score ?? 0.85) * 100, 0) }}%
                                </td>
                                
                                <!-- Status Dropdown -->
                                <td class="px-5 py-5 text-center vertical-align-top pt-4">
                                    <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST" class="inline-block w-full">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" 
                                            class="w-full bg-slate-50 border text-xs font-bold rounded-xl px-2.5 py-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#0F4C81]/20 transition-colors
                                            {{ $laporan->status == 'Masuk' ? 'border-slate-200 text-slate-600 bg-slate-50' : '' }}
                                            {{ $laporan->status == 'Diproses' ? 'border-rose-200 text-rose-600 bg-rose-50/50' : '' }}
                                            {{ $laporan->status == 'Selesai' ? 'border-emerald-200 text-emerald-600 bg-emerald-50/50' : '' }}">
                                            
                                            <option value="Masuk" class="bg-white text-slate-700" {{ $laporan->status == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                            <option value="Diproses" class="bg-white text-rose-600" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="Selesai" class="bg-white text-emerald-600" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ auth()->user()->role === 'superadmin' ? 9 : 8 }}" class="px-6 py-16 text-center text-slate-400 font-medium italic">
                                    Belum ada data aduan masuk saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>