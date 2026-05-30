<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport AI - Selamat Datang</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gradient-to-br from-slate-900 via-slate-850 to-slate-900 text-slate-100 min-h-screen flex flex-col justify-between">

    <header class="max-w-7xl w-full mx-auto px-8 py-6 flex justify-between items-center">
        <span class="text-xl font-black text-blue-400 tracking-wider">SmartReport AI</span>
        <a href="{{ route('login') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold transition-all shadow-lg shadow-blue-900/40">
            Masuk ke Sistem &rarr;
        </a>
    </header>

    <main class="max-w-4xl mx-auto text-center px-4 py-12 space-y-6">
        <span class="px-4 py-1.5 bg-blue-500/10 text-blue-400 text-xs font-semibold rounded-full border border-blue-500/20 uppercase tracking-widest">Informatics Smart City Project</span>
        <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white via-slate-200 to-slate-400 leading-tight">
            Prioritas Laporan Masyarakat <br><span class="text-blue-400">Berbasis AI IndoBERT</span>
        </h1>
        <p class="text-slate-400 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
            Sistem pengaduan cerdas yang mengurutkan penanganan keluhan publik secara otomatis menggunakan pemrosesan bahasa alami (NLP) demi efisiensi respon infrastruktur kota.
        </p>
        <div class="pt-4">
            <a href="{{ route('login') }}" class="inline-block bg-slate-800 hover:bg-slate-700 border border-slate-700 text-white font-medium px-8 py-3.5 rounded-xl transition-all shadow-md">
                Mulai Laporkan Keluhan
            </a>
        </div>
    </main>

    <footer class="text-center text-xs text-slate-600 py-6 border-t border-slate-800/60">
        &copy; 2026 SmartCity Informatics Platform. All Rights Reserved.
    </footer>

</body>
</html>