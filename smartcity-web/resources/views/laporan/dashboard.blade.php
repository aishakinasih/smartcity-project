<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Prioritas Urgensi AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 font-sans">

    <div class="flex h-screen overflow-hidden">
        <div class="w-64 bg-slate-950 p-6 flex flex-col justify-between hidden md:flex">
            <div class="space-y-6">
                <span class="text-xl font-black text-blue-400">SmartCity AI</span>
                <nav class="space-y-2">
                    <a href="#" class="flex items-center space-x-3 px-4 py-2.5 bg-slate-800 text-blue-400 font-medium rounded-xl">
                        <span>Antrean Laporan (AI)</span>
                    </a>
                    <a href="{{ route('laporan.index') }}" class="flex items-center space-x-3 px-4 py-2.5 text-slate-400 hover:bg-slate-900 rounded-xl">
                        <span>&larr; Halaman Form</span>
                    </a>
                </nav>
            </div>
            <div class="text-xs text-slate-600 border-t border-slate-800 pt-4">IndoBERT Classifier Engine v1.0</div>
        </div>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-slate-950/50 border-b border-slate-800 px-8 py-4 flex justify-between items-center sticky top-0 z-10 backdrop-blur">
                <h2 class="text-lg font-bold">Antrean Urgensi Laporan Masyarakat</h2>
                <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs font-semibold rounded-full border border-blue-500/20">Model NLP Aktif</span>
            </header>

            <main class="p-8">
                <div class="bg-slate-950 rounded-2xl border border-slate-800 overflow-hidden shadow-xl">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-900/50 text-slate-400 text-xs font-semibold uppercase border-b border-slate-800">
                                <th class="px-6 py-4">Isi Keluhan</th>
                                <th class="px-6 py-4">Instansi</th>
                                <th class="px-6 py-4">Lokasi</th>
                                <th class="px-6 py-4 text-center">Foto Bukti</th>
                                <th class="px-6 py-4 text-center">Prediksi Urgensi AI</th>
                                <th class="px-6 py-4 text-center">Conf. Score</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800/60 text-sm">
                            @forelse($laporans as $laporan)
                            <tr class="hover:bg-slate-900/30">
                                <td class="px-6 py-4 max-w-md">
                                    <div class="font-semibold text-slate-200 mb-1">{{ $laporan->judul }}</div>
                                    <p class="text-slate-400 text-xs line-clamp-2">{{ $laporan->isi_laporan }}</p>
                                </td>
                                
                                <td class="px-6 py-4 text-slate-300 text-xs">
                                    <span class="px-2 py-1 bg-slate-800 rounded text-slate-200 font-medium">{{ $laporan->instansi }}</span>
                                </td>

                                <td class="px-6 py-4 text-slate-300 text-xs">{{ $laporan->lokasi }}</td>
                                
                                <td class="px-6 py-4 text-center">
                                    @if($laporan->foto)
                                        <a href="{{ asset('uploads/laporan/' . $laporan->foto) }}" target="_blank">
                                            <img src="{{ asset('uploads/laporan/' . $laporan->foto) }}" class="w-16 h-12 object-cover rounded-lg mx-auto border border-slate-700 hover:scale-105 transition-transform" alt="Bukti">
                                        </a>
                                    @else
                                        <span class="text-xs text-slate-500 italic">Tidak ada foto</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center">
                                    @if($laporan->urgensi == 'Tinggi')
                                        <span class="px-3 py-1 bg-rose-500/10 text-rose-400 text-xs font-bold rounded-full border border-rose-500/20">Tinggi / Darurat</span>
                                    @elseif($laporan->urgensi == 'Sedang')
                                        <span class="px-3 py-1 bg-amber-500/10 text-amber-400 text-xs font-bold rounded-full border border-amber-500/20">Sedang</span>
                                    @else
                                        <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-bold rounded-full border border-emerald-500/20">Rendah</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 text-center font-mono text-xs text-slate-400">
                                    {{ number_format($laporan->confidence_score * 100, 0) }}%
                                </td>

                                <td class="px-6 py-4">
                                    <span class="text-xs font-medium text-blue-400 bg-blue-950 px-2.5 py-1 rounded-md border border-blue-900">{{ $laporan->status }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-slate-500">Belum ada laporan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

</body>
</html>