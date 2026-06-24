<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporta - Public Reporting System</title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body{
            font-family:'Plus Jakarta Sans',sans-serif;
        }

        .glass{
            backdrop-filter: blur(16px);
        }

        .hero-gradient{
            background: linear-gradient(135deg,#0F4C81,#1565C0,#00B8D9);
        }
    </style>
</head>

<body class="overflow-x-hidden text-slate-800">

<div class="fixed inset-0 -z-30">

    <img
        src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop"
        class="w-full h-full object-cover">

    <div class="absolute inset-0 bg-[#0F4C81]/80"></div>

</div>

<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

        <div class="flex items-center gap-4">

            <div class="w-12 h-12 rounded-2xl hero-gradient flex items-center justify-center shadow-lg">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="w-6 h-6 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>

                </svg>

            </div>

            <div>
                <h1 class="font-bold text-xl">Reporta</h1>
                <p class="text-xs text-slate-500">Public Reporting System</p>
            </div>

        </div>

        <a href="{{ route('login') }}"
           class="px-5 py-2.5 rounded-xl text-white bg-[#0F4C81] hover:bg-[#0b3d66] transition font-semibold shadow-lg">
            Login
        </a>

    </div>
</header>

<main class="max-w-7xl mx-auto px-6 py-16">

    <div class="grid lg:grid-cols-2 gap-14 items-center">

        <div>

            <span class="inline-block px-4 py-2 bg-blue-100 text-blue-700 rounded-full text-xs font-bold tracking-widest">
                SMART CITY • DIGITAL GOVERNMENT
            </span>

            <h1 class="mt-6 text-5xl lg:text-6xl font-extrabold leading-tight text-white drop-shadow-lg">
                Manage
                <span class="text-[#0a2540]">Public Report</span>
                Faster
            </h1>

            <p class="mt-6 text-slate-100 text-lg font-semibold leading-relaxed drop-shadow-xl" style="text-shadow: 1px 1px 3px rgba(0,0,0,0.5);">
            Reporta helps government agencies and institutions receive, manage, classify, and prioritize public reports quickly, transparently, and systematically.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">

                <a href="{{ route('login') }}"
                   class="px-7 py-3 rounded-2xl bg-[#0F4C81] text-white font-semibold shadow-xl hover:scale-105 transition">
                    Start Reporting
                </a>

            </div>
              

        </div>

        <div class="space-y-6">

            <div class="bg-white/90 glass rounded-3xl p-8 shadow-xl">

                <div class="grid md:grid-cols-[220px_1fr] gap-8 items-center">

                    <div class="relative h-[220px]">
                        <canvas id="landingChart"></canvas>
                    </div>

                    <div>

                        <h3 class="text-2xl font-bold">
                            Report Status
                        </h3>

                        <p class="text-slate-500 mb-6">
                            Total Submitted Reports:
                            {{ $totalSemua }} Reports
                        </p>

                        <div class="space-y-4">
                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-700 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-[#cbd5e1]"></span> Not Yet Processed
                                </span>
                                <span class="font-bold text-slate-600">{{ $totalSemua > 0 ? round(($totalMasuk / $totalSemua) * 100) : 0 }}%</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-700 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-[#60a5fa]"></span> In Progress
                                </span>
                                <span class="font-bold text-[#60a5fa]">{{ $totalSemua > 0 ? round(($totalDiproses / $totalSemua) * 100) : 0 }}%</span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="font-semibold text-slate-700 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full bg-[#0284c7]"></span> Resolved
                                </span>
                                <span class="font-bold text-[#0284c7]">{{ $totalSemua > 0 ? round(($totalSelesai / $totalSemua) * 100) : 0 }}%</span>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

<footer class="mt-12 border-t border-slate-200 bg-white text-center py-6 text-slate-500">
    © 2026 Reporta — Public Complaint Management Platform
</footer>

<script>
document.addEventListener("DOMContentLoaded", function(){
    const ctx = document.getElementById('landingChart').getContext('2d');
    const dataMasuk = {{ $totalMasuk }};
    const dataDiproses = {{ $totalDiproses }};
    const dataSelesai = {{ $totalSelesai }};
    const totalData = {{ $totalSemua }};

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Belum Diproses', 'Diproses', 'Selesai'],
            datasets: [{
                data: totalData > 0 ? [dataMasuk, dataDiproses, dataSelesai] : [1, 1, 1],
                backgroundColor: ['#cbd5e1', '#60a5fa', '#0284c7'],
                borderWidth: 0,
                hoverOffset: 4
            }]
        },
        options:{
            plugins:{
                legend:{display:false}
            },
            cutout:'75%', 
            animation: {
                animateScale: true,
                animateRotate: true
            }
        }
    });
});
</script>

</body>
</html>