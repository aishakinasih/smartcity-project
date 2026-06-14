<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport - Pengaduan Masyarakat</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #0F4C81, #1565C0, #00B8D9); }
        .glass { backdrop-filter: blur(16px); }
    </style>
</head>
<body class="min-h-screen py-10 px-4 relative">

    <div class="fixed inset-0 -z-30">
        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2000&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#0F4C81]/85 backdrop-blur-[2px]"></div>
    </div>

    <div class="max-w-3xl mx-auto space-y-6">
        
        <div class="bg-white/95 glass border border-white/20 p-6 rounded-[2rem] shadow-2xl flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 hero-gradient rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3l7 3v6c0 5-3.5 8-7 9-3.5-1-7-4-7-9V6l7-3z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">SmartReport AI</h1>
                    <p class="text-slate-500 text-xs">Masuk sebagai: <span class="text-[#0F4C81] font-bold">{{ auth()->user()->name }}</span></p>
                </div>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.show') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02]">Profil</a>
                <a href="{{ route('laporan.riwayat') }}" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02]">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="h-10 px-6 hero-gradient text-white text-xs font-bold rounded-2xl transition-all duration-300 flex items-center justify-center shadow-lg shadow-blue-500/20 hover:scale-[1.02]">Keluar</button>
                </form>
            </div>
        </div>

        @if(session('success'))
    <div class="bg-emerald-500/10 backdrop-blur-md border border-emerald-500/30 p-6 rounded-[2rem] shadow-xl">
        <p class="font-bold text-emerald-600 text-sm">Laporan berhasil terkirim dan otomatis dianalisis AI!</p>
        @auth
            @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                <a href="{{ route('laporan.dashboard') }}" class="text-xs underline text-emerald-700 font-bold block mt-1.5 hover:text-emerald-800">Buka Dashboard Antrean Admin &rarr;</a>
            @else
                <a href="{{ route('laporan.riwayat') }}" class="text-xs underline text-emerald-700 font-bold block mt-1.5 hover:text-emerald-800">Lihat Status Perkembangan Laporan Saya &rarr;</a>
            @endif
        @endauth
    </div>
@endif

        <div class="bg-white/95 glass border border-white/20 p-8 md:p-10 rounded-[2.5rem] shadow-2xl">
            <h2 class="text-xl font-extrabold text-slate-800 mb-8">Buat Pengaduan Baru</h2>
            
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Tujuan Instansi</label>
                    <select name="instansi" required class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium">
                        <option value="" disabled selected>Pilih Instansi Tujuan</option>
                        <option value="DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN">1. DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN</option>
                        <option value="DINAS SOSIAL">2. DINAS SOSIAL</option>
                        <option value="DINAS PERHUBUNGAN">3. DINAS PERHUBUNGAN</option>
                        <option value="SEKRETARIAT DAERAH">4. SEKRETARIAT DAERAH</option>
                        <option value="SEKRETARIAT DPRD">5. SEKRETARIAT DPRD</option>
                        <option value="DINAS PENDIDIKAN">6. DINAS PENDIDIKAN</option>
                        <option value="SATUAN POLISI PAMONG PRAJA">7. SATUAN POLISI PAMONG PRAJA</option>
                        <option value="DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL">8. DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL</option>
                        <option value="DINAS KESEHATAN">9. DINAS KESEHATAN</option>
                        <option value="BADAN PENANGGULANGAN BENCANA DAERAH">10. BADAN PENANGGULANGAN BENCANA DAERAH</option>
                        <option value="DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN">11. DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</option>
                        <option value="DINAS TENAGA KERJA DAN TRANSMIGRASI">12. DINAS TENAGA KERJA DAN TRANSMIGRASI</option>
                        <option value="DINAS LINGKUNGAN HIDUP DAN KEHUTANAN">13. DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Judul Laporan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Jalan Rusak Parah" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Jatinangor, Kab. Sumedang" class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium">
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Isi Laporan Keluhan</label>
                    <textarea name="isi_laporan" rows="4" required placeholder="Tuliskan keluhan lengkap di sini..." class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:outline-none focus:ring-4 focus:ring-[#0F4C81]/10 text-sm text-slate-800 font-medium resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-extrabold uppercase text-[#0F4C81] mb-2.5 tracking-[0.15em]">Foto Bukti Kejadian</label>
                    <input type="file" name="foto" accept="image/*" class="w-full p-2 bg-slate-50 border border-slate-100 rounded-2xl text-sm text-slate-500 file:bg-[#0F4C81] file:text-white file:border-0 file:px-4 file:py-2.5 file:rounded-xl file:cursor-pointer">
                </div>

                <button type="submit" class="w-full hero-gradient text-white font-bold py-4 rounded-2xl hover:scale-[1.01] transition-all duration-300 text-sm shadow-xl shadow-blue-500/20">
                    Kirim Pengaduan 
                </button>
            </form>
        </div>
    </div>
</body>
</html>