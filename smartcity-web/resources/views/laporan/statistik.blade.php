<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report Statistics - Reporta</title>
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

    <!-- SIDEBAR -->
    <div class="w-64 bg-white/95 glass p-6 flex flex-col justify-between hidden md:flex border-r border-white/20 shrink-0 shadow-2xl z-10 sticky top-0 h-screen">
    <div class="space-y-6">
        <div class="flex flex-col border-b border-slate-100 pb-6">
            
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl hero-gradient flex items-center justify-center shadow-lg shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-black text-[#0F4C81] tracking-tight block leading-tight">Reporta</span>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest block leading-tight">
                        @if(auth()->user()->role === 'superadmin') Super Admin @else Agency Admin @endif
                    </span>
                </div>
            </div>
            
        </div>

            <nav class="space-y-2">
                <a href="{{ route('laporan.dashboard') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all text-xs font-bold uppercase tracking-wide
                    {{ request()->routeIs('laporan.dashboard') ? 'hero-gradient text-white border-transparent' : 'text-slate-500 hover:text-[#0F4C81] hover:bg-slate-50 border-transparent' }}">
                    <span>Report Queue</span>
                </a>
                
                <a href="{{ route('laporan.statistik') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl border transition-all text-xs font-bold uppercase tracking-wide group
                    {{ request()->routeIs('laporan.statistik') ? 'hero-gradient text-white border-transparent' : 'text-slate-500 hover:text-[#0F4C81] hover:bg-slate-50 border-transparent' }}">
                    <span>Charts & Statistics</span>
                </a>
            </nav>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="flex-1 flex flex-col min-w-0">
        
        <!-- HEADER UTAMA -->
        <header class="bg-white/95 glass border-b border-white/20 px-8 py-4 flex justify-between items-center sticky top-0 z-10 shadow-sm">
            <div>
                @if(auth()->user()->role !== 'superadmin' && auth()->user()->instansi)
                    <span class="text-[10px] font-bold text-[#0F4C81] uppercase tracking-wider block">FOCUSED AGENCY</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">{{ auth()->user()->instansi }}</h2>
                @else
                    <span class="text-[10px] font-bold text-[#1565C0] uppercase tracking-wider block">GLOBAL CONTROL</span>
                    <h2 class="text-base font-extrabold text-slate-800 uppercase tracking-tight">GLOBAL SUPERADMIN (ALL AGENCIES)</h2>
                @endif
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-800">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-400 font-extrabold capitalize tracking-wide">{{ auth()->user()->role }}</p>
                </div>
                <span class="h-6 w-px bg-slate-200 hidden sm:block"></span>
                
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                        class="flex items-center w-full space-x-3 px-4 py-2.5 rounded-xl border transition-all text-xs font-bold uppercase tracking-wide hero-gradient text-white border-transparent hover:opacity-90">
                        <span>Sign Out</span>
                    </button>
                </form>
                <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </header>

        <!-- KONTEN STATISTIK -->
        <main class="p-8 space-y-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Grafik Ringkasan Kinerja -->
                <div class="lg:col-span-2 bg-white/95 glass p-6 rounded-[2rem] border border-white/20 shadow-2xl flex flex-col md:flex-row items-center justify-around gap-6">
                    <div class="flex flex-col space-y-2 text-center md:text-left">
                        <h3 class="text-base font-extrabold text-slate-800">Status Performance Percentage</h3>    
                        <div class="pt-4 space-y-2 text-xs font-bold text-slate-500 uppercase tracking-wide">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-[#cbd5e1] inline-block"></span>
                                <span>Incoming: <b class="text-slate-800 font-extrabold">{{ $totalMasuk }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-[#60a5fa] inline-block"></span>
                                <span>In-Progress: <b class="text-[#60a5fa] font-extrabold">{{ $totalDiproses }}</b></span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-[#0284c7] inline-block"></span>
                                <span>Completed: <b class="text-[#0284c7] font-extrabold">{{ $totalSelesai }}</b></span>
                            </div>
                        </div>
                    </div>
                    <div class="w-48 h-48 relative flex-shrink-0">
                        @if($totalSemua > 0)
                            <canvas id="chartStatusLaporan"></canvas>
                        @else
                            <div class="absolute inset-0 flex items-center text-center justify-center border border-dashed border-slate-200 rounded-full text-xs text-slate-400 font-medium">
                                No chart data
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Detail Beban Wilayah / Instansi -->
                <div class="bg-white/95 glass p-6 rounded-[2rem] border border-white/20 shadow-2xl flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs font-extrabold text-[#0F4C81] uppercase tracking-[0.15em] mb-3">Regional Coverage</h3>
                        
                        @if(auth()->user()->role === 'superadmin')
                            <p class="text-xs text-slate-400 font-normal mb-4">Showing total complaint load distribution for each agency:</p>
                            <div class="space-y-2.5 max-h-[160px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($laporanPerInstansi as $instansi)
                                    <div class="flex justify-between items-center bg-slate-50 p-2.5 border border-slate-100 rounded-xl text-xs font-bold text-slate-700">
                                        <span class="font-bold text-slate-800 truncate max-w-[170px] uppercase text-[11px]">{{ $instansi->instansi }}</span>
                                        <span class="px-2 py-0.5 bg-white border border-slate-200 font-mono font-bold text-[#0F4C81] rounded-md shadow-2xs">{{ $instansi->total }} reports</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400 font-normal mb-3">Your account is restricted to managing internal operational data:</p>
                            <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl space-y-2">
                                <p class="text-xs font-extrabold text-[#0F4C81] uppercase tracking-wide">{{ auth()->user()->instansi }}</p>
                                <p class="text-xs text-slate-500 leading-relaxed font-normal">All visualizations in the adjacent chart only calculate and accumulate data intended for your working agency.</p>
                            </div>
                        @endif
                    </div>
                    <div class="text-[10px] text-slate-400 font-bold tracking-wide mt-4 pt-2 border-t border-slate-100 uppercase">
                        Sync Status: Actively Connected
                    </div>
                </div>
            </div>

            <!-- Ringkasan Kartu Metrik -->
            <section class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider pl-2 drop-shadow-sm">Metric Summary</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">Total Reports</p>
                        <p class="text-3xl font-black text-slate-800 mt-2">{{ $totalSemua }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="hero-gradient h-full rounded-full" style="width: 100%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-slate-400 uppercase tracking-wide">Incoming Reports</p>
                        <p class="text-3xl font-black text-slate-600 mt-2">{{ $totalMasuk }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-slate-400 h-full rounded-full" style="width: {{ $totalSemua ? ($totalMasuk / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                    
                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-blue-400 uppercase tracking-wide">In-Progress</p>
                        <p class="text-3xl font-black text-blue-600 mt-2">{{ $totalDiproses }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-blue-500 h-full rounded-full" style="width: {{ $totalSemua ? ($totalDiproses / $totalSemua) * 100 : 0 }}%"></div>
                        </div>
                    </div>

                    <div class="bg-white/95 glass p-5 rounded-2xl border border-white/20 shadow-xl">
                        <p class="text-xs font-extrabold text-sky-600 uppercase tracking-wide">Completed</p>
                        <p class="text-3xl font-black text-sky-700 mt-2">{{ $totalSelesai }}</p>
                        <div class="w-full bg-slate-100 h-1.5 rounded-full mt-4 overflow-hidden">
                            <div class="bg-sky-600 h-full rounded-full" style="width: {{ $totalSemua ? ($totalSelesai / $totalSemua) * 100 : 0 }}%"></div>
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
                    labels: ['Incoming', 'In-Progress', 'Completed'],
                    datasets: [{
                        data: [{{ $totalMasuk }}, {{ $totalDiproses }}, {{ $totalSelesai }}],
                        backgroundColor: [
                            '#cbd5e1', // Slate for Incoming
                            '#60a5fa', // Rose for In-Progress
                            '#0284c7'  // Emerald for Completed
                        ],
                        borderWidth: 0,
                        borderColor: '#ffffff',
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