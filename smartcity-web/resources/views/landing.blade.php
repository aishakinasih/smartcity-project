<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport AI - Selamat Datang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 text-slate-100 min-h-screen flex flex-col justify-between">

    <header class="max-w-7xl w-full mx-auto px-8 py-6 flex justify-between items-center">
        <span class="text-xl font-black text-blue-400 tracking-wider">SmartReport AI</span>
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-900/40">
            Masuk ke Sistem 
        </a>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center w-full my-auto">
        
        <div class="space-y-6 text-center lg:text-left">
            <div>
                <span class="px-4 py-1.5 bg-blue-500/10 text-blue-400 text-xs font-semibold rounded-full border border-blue-500/20 uppercase tracking-widest">
                    Informatics Smart City Project
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400 leading-tight">
                Prioritas Laporan Masyarakat <br><span class="text-blue-400">Berbasis AI IndoBERT</span>
            </h1>
            <p class="text-slate-400 text-base md:text-lg max-w-2xl mx-auto lg:mx-0 leading-relaxed">
                Sistem pengaduan cerdas yang mengurutkan penanganan keluhan publik secara otomatis menggunakan pemrosesan bahasa alami (NLP) demi efisiensi respon infrastruktur kota.
            </p>
            <div class="pt-4">
                <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-900/40">
                    Mulai Laporkan Keluhan
                </a>
            </div>
        </div>

        <div class="bg-slate-800/40 border border-slate-700/50 rounded-3xl p-6 md:p-8 backdrop-blur-sm shadow-xl flex flex-col md:flex-row items-center gap-8 max-w-xl mx-auto lg:w-full">
            
            <div class="relative w-48 h-48 flex-shrink-0">
                <canvas id="landingChart"></canvas>
            </div>

            <div class="w-full space-y-4">
                <div>
                    <h3 class="text-lg font-bold text-white">Status Penanganan</h3>
                    <p class="text-xs text-slate-400">Total laporan masuk: {{ $totalSemua }} keluhan</p>
                </div>
                
                <div class="space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="text-slate-300">Belum Diproses</span>
                        </div>
                        <span class="font-semibold text-amber-400">
                            {{ $totalSemua > 0 ? round(($totalMasuk / $totalSemua) * 100) : 0 }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-slate-300">Sedang Diproses</span>
                        </div>
                        <span class="font-semibold text-blue-400">
                            {{ $totalSemua > 0 ? round(($totalDiproses / $totalSemua) * 100) : 0 }}%
                        </span>
                    </div>

                    <div class="flex items-center justify-between text-sm">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-slate-300">Selesai Ditangani</span>
                        </div>
                        <span class="font-semibold text-emerald-400">
                            {{ $totalSemua > 0 ? round(($totalSelesai / $totalSemua) * 100) : 0 }}%
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <footer class="text-center text-xs text-slate-600 py-6 border-t border-slate-800/60 w-full">
        &copy; 2026 SmartCity Informatics Platform. All Rights Reserved.
    </footer>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('landingChart').getContext('2d');
            
            // Mengambil nilai data dari PHP (jika kosong, diisi nilai default 1 agar grafik tidak kosong/error)
            const dataMasuk = {{ $totalMasuk }};
            const dataDiproses = {{ $totalDiproses }};
            const dataSelesai = {{ $totalSelesai }};
            const totalData = {{ $totalSemua }};

            // Jika belum ada data sama sekali di DB, buat grafik contoh (placeholder) berwujud transparan
            const chartData = totalData > 0 ? [dataMasuk, dataDiproses, dataSelesai] : [1, 1, 1];
            const chartColors = totalData > 0 ? ['#f59e0b', '#3b82f6', '#10b981'] : ['#475569', '#334155', '#1e293b'];

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Belum Diproses', 'Sedang Diproses', 'Selesai'],
                    datasets: [{
                        data: chartData,
                        backgroundColor: chartColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // dimatikan karena sudah kita buat kustom di sisi kanan HTML
                        },
                        tooltip: {
                            enabled: totalData > 0 // aktif jika ada data riil saja
                        }
                    },
                    cutout: '75%' // Membuat lingkaran dalam chart menjadi lebih tipis dan elegan
                }
            });
        });
    </script>

</body>
</html>