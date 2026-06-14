<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Laporan - SmartCity AI</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all group
                   {{ request()->routeIs('laporan.dashboard') ? 'bg-slate-800 text-blue-400 font-semibold border-slate-700/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60 border-transparent' }}">
                    <span>Antrean Laporan AI</span>
                </a>
                
                <a href="{{ route('laporan.statistik') }}" 
                   class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all shadow-sm
                   {{ request()->routeIs('laporan.statistik') ? 'bg-slate-800 text-blue-400 font-semibold border-slate-700/40' : 'text-slate-400 hover:text-slate-200 hover:bg-slate-900/60 border-transparent' }}">
                    <span>Grafik dan Statistik</span>
                </a>
            </nav>
        </div>
        <div class="text-xs text-slate-600 border-t border-slate-800 pt-4 font-medium">IndoBERT Classifier Engine v1.0</div>
    </div>

    <div class="flex-1 flex flex-col overflow-y-auto">
        
        <header class="bg-slate-950/70 border-b border-slate-800 px-8 py-4 flex justify-between items-center sticky top-0 z-10 backdrop-blur">
            <div>
                @if(auth()->user()->role !== 'superadmin' && auth()->user()->instansi)
                    <span class="text-[10px] font-bold text-blue-400 uppercase tracking-wider block">INSTANSI FOKUS</span>
                    <h2 class="text-lg font-bold text-slate-200 uppercase">{{ auth()->user()->instansi }}</h2>
                @else
                    <span class="text-[10px] font-bold text-indigo-400 uppercase tracking-wider block">KONTROL GLOBAL</span>
                    <h2 class="text-lg font-bold text-slate-200 uppercase">GLOBAL SUPERADMIN (SEMUA INSTANSI)</h2>
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
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 bg-slate-950 p-6 rounded-2xl border border-slate-800 shadow-xl flex flex-col md:flex-row items-center justify-around gap-6">
                    <div class="flex flex-col space-y-2 text-center md:text-left">
                        <h3 class="text-base font-bold text-slate-200">Persentase Status Kerja</h3>
                        <p class="text-xs text-slate-400 max-w-xs">Grafik lingkaran pembagian porsi penanganan keluhan masyarakat yang dikelola sistem.</p>
                        
                        <div class="pt-4 space-y-2 text-xs font-semibold text-slate-400">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-slate-500 inline-block"></span>
                                <span>Masuk: <b class="text-slate-200">{{ $totalMasuk }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                                <span>Diproses: <b class="text-red-400">{{ $totalDiproses }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                <span>Selesai: <b class="text-emerald-400">{{ $totalSelesai }}</b></span>
                            </div>
                        </div>
                    </div>

                    <div class="w-48 h-48 relative flex-shrink-0">
                        @if($totalSemua > 0)
                            <canvas id="chartStatusLaporan"></canvas>
                        @else
                            <div class="absolute inset-0 flex items-center text-center justify-center border border-dashed border-slate-800 rounded-full text-xs text-slate-600 font-medium">
                                Tidak ada data grafik
                            </div>
                        @endif
                    </div>
                </div>

                <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 shadow-xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Cakupan Informasi Wilayah</h3>
                        
                        @if(auth()->user()->role === 'superadmin')
                            <p class="text-xs text-slate-500 mb-4">Menampilkan rincian beban total pengaduan yang didistribusikan ke setiap dinas kota:</p>
                            <div class="space-y-2.5 max-h-[160px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($laporanPerInstansi as $instansi)
                                    <div class="flex justify-between items-center bg-slate-900/60 p-2.5 border border-slate-800/40 rounded-xl text-xs">
                                        <span class="font-medium text-slate-300 truncate max-w-[170px] uppercase">{{ $instansi->instansi }}</span>
                                        <span class="px-2 py-0.5 bg-slate-800 border border-slate-700/60 font-mono font-bold text-blue-400 rounded-md">{{ $instansi->total }} aduan</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-500 mb-3">Akun Anda dikunci khusus untuk mengelola data operasional internal:</p>
                            <div class="bg-blue-950/20 border border-blue-900/30 p-4 rounded-xl space-y-2">
                                <p class="text-xs font-bold text-blue-400 uppercase tracking-wide">{{ auth()->user()->instansi }}</p>
                                <p class="text-xs text-slate-400 leading-relaxed font-medium">Seluruh visualisasi bagan grafik bulat di samping hanya menghitung dan mengakumulasikan data yang ditujukan untuk instansi kerja Anda.</p>
                            </div>
                        @endif
                    </div>

                    <div class="text-[10px] text-slate-600 font-bold tracking-wide mt-4 pt-2 border-t border-slate-900 uppercase">
                        Status Sinkronisasi: Aktif Terhubung
                    </div>
                </div>

            </div>

            <section>
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-4">Ringkasan Angka Metrik</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800/80 shadow-md">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Total Pengaduan</p>
                        <p class="text-3xl font-black text-slate-100 mt-2">{{ $totalSemua }}</p>
                        <div class="w-full bg-slate-900 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800/80 shadow-md">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Laporan Masuk</p>
                        <p class="text-3xl font-black text-slate-300 mt-2">{{ $totalMasuk }}</p>
                        <div class="w-full bg-slate-900 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-slate-600 h-full rounded-full" style="width: {{ $totalSemua ? ($totalMasuk / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800/80 shadow-md">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Sedang Diproses</p>
                        <p class="text-3xl font-black text-red-400 mt-2">{{ $totalDiproses }}</p>
                        <div class="w-full bg-slate-900 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-red-500 h-full rounded-full" style="width: {{ $totalSemua ? ($totalDiproses / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800/80 shadow-md">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Selesai Ditangani</p>
                        <p class="text-3xl font-black text-emerald-400 mt-2">{{ $totalSelesai }}</p>
                        <div class="w-full bg-slate-900 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-emerald-500 h-full rounded-full" style="width: {{ $totalSemua ? ($totalSelesai / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                </div>
            </section>

        </main>
    </div>

    @if($totalSemua > 0)
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('chartStatusLaporan').getContext('2d');
            
            new Chart(ctx, {
                type: 'doughnut', // Membuat tipe grafik bulat donat modern
                data: {
                    labels: ['Masuk', 'Diproses', 'Selesai'],
                    datasets: [{
                        data: [{{ $totalMasuk }}, {{ $totalDiproses }}, {{ $totalSelesai }}],
                        backgroundColor: [
                            '#64748b', // Slate Gray untuk Masuk
                            '#ef4444, // red Yellow untuk Diproses
                            '#10b981'  // Emerald Green untuk Selesai
                        ],
                        borderWidth: 3,
                        borderColor: '#020617', // Menyamakan warna border gap dengan latar bg-slate-950
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Kita matikan legend bawaan karena sudah membuat legenda kustom di sebelah kiri kodenya
                        }
                    },
                    cutout: '75%' // Membuat lingkaran tengah donat menjadi lebih tipis dan estetik
                }
            });
        });
    </script>
    @endif

</body>
</html>