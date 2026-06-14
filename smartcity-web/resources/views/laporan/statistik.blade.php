<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistik Laporan - Reporta</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                <span class="text-xl font-black text-[#0F4C81] tracking-tight">Reporta</span>
                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                    @if(auth()->user()->role === 'superadmin') Super Admin Panel @else Admin Instansi Panel @endif
                </span>
            </div>
            
            <nav class="space-y-2">
                <a href="{{ route('laporan.dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all text-xs font-bold uppercase tracking-wide
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
                    <span class="text-[10px] font-bold text-[#0F4C81] uppercase tracking-wider block">INSTANSI FOKUS</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">{{ auth()->user()->instansi }}</h2>
                @else
                    <span class="text-[10px] font-bold text-[#1565C0] uppercase tracking-wider block">KONTROL GLOBAL</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">GLOBAL SUPERADMIN (SEMUA INSTANSI)</h2>
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

        <!-- KONTEN STATISTIK -->
        <main class="p-8 space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Grafik Donat Ringkasan Kinerja -->
                <div class="lg:col-span-2 bg-white/95 glass p-6 rounded-[2rem] border border-white/20 shadow-2xl flex flex-col md:flex-row items-center justify-around gap-6">
                    <div class="flex flex-col space-y-2 text-center md:text-left">
                        <h3 class="text-base font-extrabold text-slate-800">Persentase Status Kerja</h3>
                        <p class="text-xs text-slate-400 max-w-xs font-normal">Grafik lingkaran pembagian porsi penanganan keluhan masyarakat yang dikelola sistem.</p>
                        
                        <div class="pt-4 space-y-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-slate-400 inline-block"></span>
                                <span>Masuk: <b class="text-slate-800 font-extrabold">{{ $totalMasuk }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                                <span>Diproses: <b class="text-rose-600 font-extrabold">{{ $totalDiproses }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                                <span>Selesai: <b class="text-emerald-600 font-extrabold">{{ $totalSelesai }}</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="w-48 h-48 relative flex-shrink-0">
                        @if($totalSemua > 0)
                            <canvas id="chartStatusLaporan"></canvas>
                        @else
                            <div class="absolute inset-0 flex items-center text-center justify-center border border-dashed border-slate-200 rounded-full text-xs text-slate-400 font-medium">
                                Tidak ada data grafik
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detail Beban Wilayah / Instansi -->
                <div class="bg-white/95 glass p-6 rounded-[2rem] border border-white/20 shadow-2xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-extrabold text-[#0F4C81] uppercase tracking-[0.15em] mb-3">Cakupan Informasi Wilayah</h3>
                        
                        @if(auth()->user()->role === 'superadmin')
                            <p class="text-xs text-slate-400 font-normal mb-4">Menampilkan rincian beban total pengaduan yang didistribusikan ke setiap dinas kota:</p>
                            <div class="space-y-2.5 max-h-[160px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($laporanPerInstansi as $instansi)
                                    <div class="flex justify-between items-center bg-slate-50 p-2.5 border border-slate-100 rounded-xl text-xs font-bold text-slate-700">
                                        <span class="font-bold text-slate-800 truncate max-w-[170px] uppercase text-[11px]">{{ $instansi->instansi }}</span>
                                        <span class="px-2 py-0.5 bg-white border border-slate-200 font-mono font-bold text-[#0F4C81] rounded-md shadow-2xs">{{ $instansi->total }} aduan</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 font-normal mb-3">Akun Anda dikunci khusus untuk mengelola data operasional internal:</p>
                            <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl space-y-2">
                                <p class="text-xs font-extrabold text-[#0F4C81] uppercase tracking-wide">{{ auth()->user()->instansi }}</p>
                                <p class="text-xs text-slate-500 leading-relaxed font-normal">Seluruh visualisasi bagan grafik bulat di samping hanya menghitung dan mengakumulasikan data yang ditujukan untuk instansi kerja Anda.</p>
                            </div>
                        @endif
                    </div>
                    <div class="text-[10px] text-slate-400 font-bold tracking-wide mt-4 pt-2 border-t border-slate-100 uppercase">
                        Status Sinkronisasi: Aktif Terhubung
                    </div>
                </div>
            </div>

            <!-- Ringkasan Kartu Metrik -->
            <section class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider pl-2 drop-shadow-sm">Ringkasan Angka Metrik</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">Total Pengaduan</p>
                        <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalSemua }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="hero-gradient h-full rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">Laporan Masuk</p>
                        <p class="text-3xl font-black text-slate-600 mt-2">{{ $totalMasuk }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-slate-400 h-full rounded-full" style="width: {{ $totalSemua ? ($totalMasuk / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-rose-400 uppercase tracking-wide">Sedang Diproses</p>
                        <p class="text-3xl font-black text-rose-600 mt-2">{{ $totalDiproses }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-rose-500 h-full rounded-full" style="width: {{ $totalSemua ? ($totalDiproses / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-emerald-400 uppercase tracking-wide">Selesai Ditangani</p>
                        <p class="text-3xl font-black text-emerald-600 mt-2">{{ $totalSelesai }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
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
                type: 'doughnut',
                data: {
                    labels: ['Masuk', 'Diproses', 'Selesai'],
                    datasets: [{
                        data: [{{ $totalMasuk }}, {{ $totalDiproses }}, {{ $totalSelesai }}],
                        backgroundColor: [
                            '#94a3b8', // Slate untuk Masuk
                            '#f43f5e', // Rose untuk Diproses
                            '#10b981'  // Emerald untuk Selesai
                        ],
                        borderWidth: 3,
                        borderColor: '#ffffff', // Border putih bersih menyatu dengan glassmorphism
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    cutout: '75%'
                }
            });
        });
    </script>
    @endif
</body>
</html>