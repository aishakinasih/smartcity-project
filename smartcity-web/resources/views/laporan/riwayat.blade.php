<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport - Riwayat Pengaduan</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#090e1a] text-slate-100 font-sans antialiased min-h-screen">

    <div class="max-w-6xl mx-auto p-4 md:p-6 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-[#030712] py-3 px-5 rounded-2xl border border-slate-800/70 shadow-xl">
            <div>
                <h1 class="text-lg font-bold tracking-tight bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                    Riwayat Pengaduan Saya
                </h1>
                <p class="text-slate-400 text-[11px] mt-0.5">
                    Selamat datang kembali, <span class="text-slate-200 font-semibold">{{ auth()->user()->name }}</span>
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('laporan.index') }}" class="h-9 px-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                    <span class="whitespace-nowrap">Buat Laporan Baru</span>
                </a>
                
                <a href="{{ route('profile.show') }}" class="h-9 px-3.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                    Profil Saya
                </a>
                
                <a href="{{ route('logout') }}" class="h-9 px-3.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10"
                   onclick="event.preventDefault(); document.getElementById('riwayat-logout-form').submit();">
                    Keluar
                </a>
                <form id="riwayat-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>

        <div class="bg-[#030712] rounded-2xl border border-slate-800/80 shadow-2xl overflow-x-auto JSON_layer">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="bg-[#090e1a]/60 text-slate-400 text-xs font-bold uppercase border-b border-slate-800 tracking-wider">
                        <th class="px-6 py-4.5 w-[35%]">Laporan Anda</th>
                        <th class="px-6 py-4.5 w-[30%]">Tujuan Instansi</th>
                        <th class="px-6 py-4.5 w-[15%]">Lokasi</th>
                        <th class="px-6 py-4.5 text-center w-[20%]">Status Kelanjutan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800/50 text-sm">
                    @forelse($laporans as $laporan)
                    <tr class="hover:bg-slate-900/20 transition-colors group">
                        
                        <td class="px-6 py-5">
                            <div class="font-bold text-slate-200 group-hover:text-blue-400 transition-colors mb-1.5 text-base">
                                {{ $laporan->judul ?: '-' }}
                            </div>
                            <p class="text-slate-400 text-xs leading-relaxed max-w-sm break-words">
                                {{ $laporan->isi_laporan ?: '-' }}
                            </p>
                            <span class="text-[10px] text-slate-500 font-medium block mt-3">
                                 {{ $laporan->created_at ? $laporan->created_at->format('d M Y, H:i') : 'Tanggal tidak tersedia' }} WIB
                            </span>
                        </td>
                        
                        <td class="px-6 py-5 vertical-align-middle">
                            <span class="inline-block px-3 py-1.5 bg-[#090e1a] border border-slate-800 rounded-lg text-slate-300 font-semibold text-xs tracking-wide uppercase max-w-xs break-words whitespace-normal shadow-sm">
                                 {{ $laporan->instansi }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-5 text-slate-300 font-medium text-xs">
                            <div class="flex items-center gap-1 capitalize">
                                 {{ $laporan->lokasi ?: '-' }}
                            </div>
                        </td>
                        
                        <td class="px-6 py-5 text-center">
                            @if($laporan->status == 'Masuk')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-slate-900 border border-slate-700/80 text-slate-300 text-xs font-bold rounded-full shadow-xs">
                                     Laporan Masuk
                                </span>
                            @elseif($laporan->status == 'Diproses')
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-bold rounded-full shadow-xs">
                                     Sedang Diproses
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-bold rounded-full shadow-xs">
                                     Selesai Ditangani
                                </span>
                            @endif
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center text-slate-500 font-medium">
                            <div class="text-3xl mb-2">📭</div>
                            Anda belum pernah mengirimkan laporan pengaduan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>

</body>
</html>