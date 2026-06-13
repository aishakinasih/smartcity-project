<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport - Pengaduan Masyarakat</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-[#090e1a] text-slate-100 font-sans antialiased min-h-screen">

    <div class="max-w-3xl mx-auto p-4 md:p-6 space-y-6">
        
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 bg-[#030712] py-3 px-5 rounded-2xl border border-slate-800/70 shadow-xl">
            <div>
                <h1 class="text-lg font-bold tracking-tight bg-gradient-to-r from-blue-400 to-indigo-400 bg-clip-text text-transparent">
                    SmartReport AI
                </h1>
                <p class="text-slate-400 text-[11px] mt-0.5">
                    Masuk sebagai: <span class="text-slate-200 font-semibold">{{ auth()->user()->name }}</span>
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <a href="{{ route('profile.show') }}" class="h-9 px-3.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                    Profil Saya
                </a>

                <a href="{{ route('laporan.riwayat') }}" class="h-9 px-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                    <span class="whitespace-nowrap">Lihat Riwayat Laporan</span>
                </a>
                
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="h-9 px-3.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-xl transition-all flex items-center justify-center cursor-pointer shadow-md shadow-blue-900/10">
                        Keluar
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 p-4 rounded-xl text-emerald-400 text-sm">
                <p class="font-semibold">{{ session('success') }}</p>
                
                @auth
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                        <a href="{{ route('laporan.dashboard') }}" class="text-xs underline text-emerald-400 hover:text-emerald-300 font-medium block mt-1.5">
                            Buka Dashboard Antrean Admin &rarr;
                        </a>
                    @else
                        <a href="{{ route('laporan.riwayat') }}" class="text-xs underline text-emerald-400 hover:text-emerald-300 font-medium block mt-1.5">
                            Lihat Status Perkembangan Laporan Saya &rarr;
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="bg-[#030712] p-6 md:p-8 rounded-2xl border border-slate-800/80 shadow-2xl">
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2.5 tracking-wider">Tujuan Instansi</label>
                    <select name="instansi" required class="w-full px-4 py-3 bg-[#090e1a] border border-slate-800 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm text-slate-200 cursor-pointer transition-all">
                        <option value="" disabled selected class="text-slate-500">Pilih Instansi Tujuan</option>
                        <option value="DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN" class="bg-[#030712]">1. DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN (damkar)</option>
                        <option value="DINAS SOSIAL" class="bg-[#030712]">2. DINAS SOSIAL</option>
                        <option value="DINAS PERHUBUNGAN" class="bg-[#030712]">3. DINAS PERHUBUNGAN</option>
                        <option value="SEKRETARIAT DAERAH" class="bg-[#030712]">4. SEKRETARIAT DAERAH</option>
                        <option value="SEKRETARIAT DPRD" class="bg-[#030712]">5. SEKRETARIAT DPRD</option>
                        <option value="DINAS PENDIDIKAN" class="bg-[#030712]">6. DINAS PENDIDIKAN</option>
                        <option value="SATUAN POLISI PAMONG PRAJA" class="bg-[#030712]">7. SATUAN POLISI PAMONG PRAJA (satpol pp)</option>
                        <option value="DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL" class="bg-[#030712]">8. DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL (disdukcapil)</option>
                        <option value="DINAS KESEHATAN" class="bg-[#030712]">9. DINAS KESEHATAN</option>
                        <option value="BADAN PENANGGULANGAN BENCANA DAERAH" class="bg-[#030712]">10. BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)</option>
                        <option value="DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN" class="bg-[#030712]">11. DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</option>
                        <option value="DINAS TENAGA KERJA DAN TRANSMIGRASI" class="bg-[#030712]">12. DINAS TENAGA KERJA DAN TRANSMIGRASI</option>
                        <option value="DINAS LINGKUNGAN HIDUP DAN KEHUTANAN" class="bg-[#030712]">13. DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</option>
                        <option value="RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH" class="bg-[#030712]">14. RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2.5 tracking-wider">Judul Laporan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Tanggul Sungai Jebol / Jalan Rusak Parah" 
                           class="w-full px-4 py-3 bg-[#090e1a] border border-slate-800 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm text-slate-200 placeholder:text-slate-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2.5 tracking-wider">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Jatinangor, Kab. Sumedang" 
                           class="w-full px-4 py-3 bg-[#090e1a] border border-slate-800 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm text-slate-200 placeholder:text-slate-600 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2.5 tracking-wider">Isi Laporan Keluhan</label>
                    <textarea name="isi_laporan" rows="5" required placeholder="Tuliskan keluhan lengkap di sini agar dianalisis tingkat urgensinya oleh AI..." 
                              class="w-full px-4 py-3 bg-[#090e1a] border border-slate-800 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm text-slate-200 placeholder:text-slate-600 transition-all resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase text-slate-400 mb-2.5 tracking-wider">Foto Bukti Kejadian</label>
                    <input type="file" name="foto" accept="image/*" 
                           class="w-full px-4 py-2.5 bg-[#090e1a] border border-slate-800 rounded-xl focus:outline-none focus:border-blue-500 text-sm text-slate-400 file:mr-4 file:py-1.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-800 file:text-slate-300 hover:file:bg-slate-700 file:transition-all file:cursor-pointer cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3.5 px-4 rounded-xl transition-all shadow-md shadow-blue-900/20 text-sm cursor-pointer mt-2">
                    Kirim Pengaduan &rarr;
                </button>
            </form>
        </div>
    </div>

</body>
</html>