<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartReport - Pengaduan Masyarakat</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-50 text-slate-800">

    <div class="max-w-2xl mx-auto my-12 px-4">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-extrabold text-blue-600 tracking-tight">SmartReport AI</h1>
            <p class="text-slate-500 mt-2">Layanan pengaduan masyarakat berbasis NLP IndoBERT untuk prioritas penanganan penanggulangan kota.</p>
        </div>

        <div class="text-sm text-slate-600 bg-white border border-slate-200 px-6 py-3 rounded-xl flex items-center justify-between shadow-xs mb-6">
            <div>
                <span class="text-slate-400">Masuk sebagai:</span> 
                <strong class="text-slate-700 font-semibold">{{ auth()->user()->name }}</strong>
            </div>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('laporan.riwayat') }}" class="text-blue-600 hover:text-blue-700 font-bold flex items-center space-x-1 transition-colors">
                    <span> Lihat Riwayat Laporan</span>
                </a>
                
                <span class="text-slate-200">|</span>
                
                <div class="flex items-center gap-3">
                    <a href="{{ route('profile.show') }}" class="text-xs bg-slate-800 hover:bg-slate-700 border border-slate-700 text-slate-300 px-3 py-1.5 rounded-lg transition-all font-medium">
                        Profil Saya
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-red-500/10 hover:bg-red-600 border border-red-500/20 hover:border-red-600 text-red-400 hover:text-white px-3 py-1.5 rounded-lg transition-all font-medium">
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/20 p-4 rounded-xl text-emerald-400 text-sm mb-6">
                <p class="font-semibold">{{ session('success') }}</p>
                
                @auth
                    @if(auth()->user()->role === 'superadmin' || auth()->user()->role === 'admin_instansi')
                        <a href="{{ route('laporan.dashboard') }}" class="text-xs underline hover:text-emerald-300 block mt-1">
                            Buka Dashboard Antrean Admin &rarr;
                        </a>
                    @else
                        <a href="{{ route('laporan.riwayat') }}" class="text-xs underline hover:text-emerald-300 block mt-1">
                            Lihat Status Perkembangan Laporan Saya &rarr;
                        </a>
                    @endif
                @endauth
            </div>
        @endif

        <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
            <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Tujuan Instansi</label>
                    <select name="instansi" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 bg-white">
                        <option value="" disabled selected>Pilih Instansi Tujuan</option>
                        <option value="DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN">1. DINAS PEMADAM KEBAKARAN DAN PENYELAMATAN (damkar)</option>
                        <option value="DINAS SOSIAL">6. DINAS SOSIAL</option>
                        <option value="DINAS PERHUBUNGAN">7. DINAS PERHUBUNGAN</option>
                        <option value="SEKRETARIAT DAERAH">8. SEKRETARIAT DAERAH</option>
                        <option value="SEKRETARIAT DPRD">9. SEKRETARIAT DPRD</option>
                        <option value="DINAS PENDIDIKAN">10. DINAS PENDIDIKAN</option>
                        <option value="SATUAN POLISI PAMONG PRAJA">11. SATUAN POLISI PAMONG PRAJA (satpol pp)</option>
                        <option value="DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL">12. DINAS KEPENDUDUKAN DAN PENCATATAN SIPIL (disdukcapil)</option>
                        <option value="DINAS KESEHATAN">13. DINAS KESEHATAN</option>
                        <option value="BADAN PENANGGULANGAN BENCANA DAERAH">14. BADAN PENANGGULANGAN BENCANA DAERAH (BPBD)</option>
                        <option value="DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN">15. DINAS PERUMAHAN, KAWASAN PERMUKIMAN DAN PERTANAHAN</option>
                        <option value="DINAS TENAGA KERJA DAN TRANSMIGRASI">16. DINAS TENAGA KERJA DAN TRANSMIGRASI</option>
                        <option value="DINAS LINGKUNGAN HIDUP DAN KEHUTANAN">17. DINAS LINGKUNGAN HIDUP DAN KEHUTANAN</option>
                        <option value="RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH">18. RUMAH SAKIT UMUM DAERAH UMAR WIRAHADIKUSUMAH</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Judul Laporan</label>
                    <input type="text" name="judul" required placeholder="Contoh: Tanggul Sungai Jebol / Jalan Rusak Parah" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Kejadian</label>
                    <input type="text" name="lokasi" required placeholder="Contoh: Jatinangor, Kab. Sumedang" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Isi Laporan Keluhan</label>
                    <textarea name="isi_laporan" rows="5" required placeholder="Tuliskan keluhan lengkap di sini agar dianalisis tingkat urgensinya..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Bukti Kejadian</label>
                    <input type="file" name="foto" accept="image/*" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:outline-none focus:border-blue-500 text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3.5 px-4 rounded-xl transition-colors shadow-lg cursor-pointer">
                    Kirim Pengaduan & Analisis Urgensi
                </button>
            </form>
        </div>
    </div>

</body>
</html>