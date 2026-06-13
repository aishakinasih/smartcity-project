<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Prioritas Urgensi</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans antialiased h-screen flex overflow-hidden">

    <div class="w-64 bg-slate-950 p-6 flex flex-col justify-between hidden md:flex border-r border-slate-800/60 shrink-0">
        <div class="space-y-6">
            <div class="flex flex-col">
                <span class="text-xl font-black text-blue-400 tracking-tight">SmartCity AI</span>
                <span class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">
                    @if(auth()->user()->role === 'superadmin') Super Admin Panel @else Admin Instansi Panel @endif
                </span>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('laporan.dashboard') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all shadow-sm
                   {{ request()->routeIs('laporan.dashboard') ? 'bg-slate-800 text-blue-400 font-semibold border-slate-700/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60 border-transparent' }}">
                    <span>Antrean Laporan </span>
                </a>
                
                <a href="{{ route('laporan.statistik') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all group
                   {{ request()->routeIs('laporan.statistik') ? 'bg-slate-800 text-blue-400 font-semibold border-slate-700/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60 border-transparent' }}">
                    <span>Grafik dan Statistik</span>
                </a>
            </nav>
        </div>
        
        <div>
            <a href="{{ route('profile.show') }}" class="block text-xs text-slate-300 hover:text-white font-medium py-2 px-4 rounded-lg hover:bg-slate-800 transition-all mb-1">
                ⚙️ Pengaturan Profil
            </a>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-left text-xs text-red-400 hover:text-red-300 font-medium py-2 px-4 rounded-lg hover:bg-red-500/5 transition-all cursor-pointer">
                    Sistem Keluar
                </button>
            </form>
            <div class="text-xs text-slate-600 border-t border-slate-800 pt-4 font-medium mt-4">IndoBERT Classifier Engine v1.0</div>
        </div>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <header class="bg-slate-950/70 border-b border-slate-800 px-8 py-4 flex justify-between items-center sticky top-0 z-10 backdrop-blur">
            <div>
                @if(auth()->user()->role !== 'superadmin' && auth()->user()->instansi)
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider block">INSTANSI</span>
                    <h2 class="text-lg font-bold text-slate-200 uppercase">{{ auth()->user()->instansi }}</h2>
                @else
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider block">KONTROL GLOBAL</span>
                    <h2 class="text-lg font-bold text-slate-200 uppercase">GLOBAL SUPERADMIN </h2>
                @endif
            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-semibold text-slate-300">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-500 font-medium capitalize">{{ auth()->user()->role }}</p>
                </div>
                <span class="h-6 w-px bg-slate-800 hidden sm:block"></span>
                
                <a href="{{ route('logout') }}" 
                   class="px-4 py-2 bg-slate-900 hover:bg-rose-950/40 border border-slate-800 hover:border-rose-900/40 text-rose-400 text-xs font-bold rounded-xl transition-all shadow-xs cursor-pointer"
                   onclick="event.preventDefault(); document.getElementById('admin-logout-form').submit();">
                    Keluar
                </a>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </header>

        <main class="p-8 space-y-8">
            <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden shadow-xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900/50 text-slate-400 text-xs font-semibold uppercase border-b border-slate-800 tracking-wider">
                            <th class="px-6 py-4">Isi Keluhan</th>
                            @if(auth()->user()->role === 'superadmin')
                                <th class="px-6 py-4">Instansi</th>
                            @endif
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4 text-center">Bukti FOTO</th>
                            <th class="px-6 py-4 text-center">Prediksi Urgensi</th>
                            <th class="px-6 py-4 text-center">Conf. Score</th>
                            <th class="px-6 py-4 text-center w-[180px]">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/60 text-sm">
                        @forelse($laporans as $laporan)
                        <tr class="hover:bg-slate-900/20 transition-colors">
                            <td class="px-6 py-4 max-w-xs md:max-w-md">
                                <div class="font-bold text-slate-200 mb-1 text-sm md:text-base">{{ $laporan->judul }}</div>
                                <p class="text-slate-400 text-xs leading-relaxed line-clamp-2">{{ $laporan->isi_laporan }}</p>
                            </td>
                            
                            @if(auth()->user()->role === 'superadmin')
                                <td class="px-6 py-4 text-slate-300 text-xs vertical-align-middle">
                                    <span class="px-2 py-1 bg-slate-900 border border-slate-800 rounded font-semibold text-slate-300 tracking-wide block max-w-[200px] truncate">
                                        {{ $laporan->instansi }}
                                    </span>
                                </td>
                            @endif

                            <td class="px-6 py-4 text-slate-300 font-medium text-xs capitalize">{{ $laporan->lokasi }}</td>
                            
                            <td class="px-6 py-4 text-center">
                                @if($laporan->foto)
                                    <a href="{{ asset('uploads/laporan/' . $laporan->foto) }}" target="_blank" class="inline-block">
                                        <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" class="w-14 h-10 object-cover rounded-lg mx-auto border border-slate-800 hover:scale-105 transition-all shadow-xs" alt="Bukti">
                                    </a>
                                @else
                                    <span class="text-xs text-slate-600 italic">Tidak ada foto</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if($laporan->urgensi == 'Tinggi')
                                    <span class="px-3 py-1 bg-rose-500/10 text-rose-400 text-xs font-black rounded-full border border-rose-500/20 shadow-xs">Tinggi</span>
                                @elseif($laporan->urgensi == 'Sedang')
                                    <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-black rounded-full border border-amber-500/20 shadow-xs">Sedang</span>
                                @else
                                    <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-black rounded-full border border-emerald-500/20 shadow-xs">Rendah</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center font-mono text-xs text-slate-400 font-semibold">
                                {{ number_format(($laporan->confidence_score ?? 0.85) * 100, 0) }}%
                            </td>

                            <td class="px-6 py-4 text-center">
                                <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST" class="inline-block w-full">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" 
                                        class="w-full bg-slate-900 border text-xs font-bold rounded-lg px-2.5 py-2 cursor-pointer focus:outline-none focus:ring-1 focus:ring-blue-500 transition-colors
                                        {{ $laporan->status == 'Masuk' ? 'border-slate-800 text-slate-300 bg-slate-900' : '' }}
                                        {{ $laporan->status == 'Diproses' ? 'border-amber-500/30 text-amber-400 bg-amber-500/5' : '' }}
                                        {{ $laporan->status == 'Selesai' ? 'border-emerald-500/30 text-emerald-400 bg-emerald-500/5' : '' }}">
                                        
                                        <option value="Masuk" class="bg-slate-950 text-slate-300" {{ $laporan->status == 'Masuk' ? 'selected' : '' }}>Masuk</option>
                                        <option value="Diproses" class="bg-slate-950 text-amber-400" {{ $laporan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                        <option value="Selesai" class="bg-slate-950 text-emerald-400" {{ $laporan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'superadmin' ? 7 : 6 }}" class="px-6 py-16 text-center text-slate-500 font-medium">
                                Belum ada data aduan masuk saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>