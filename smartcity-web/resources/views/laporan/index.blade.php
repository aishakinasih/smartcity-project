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

        <div class="flex justify-center items-center space-x-4 mb-8 bg-slate-100 py-2 px-4 rounded-full w-fit mx-auto text-xs shadow-xs border border-slate-200">
            <span class="text-slate-600">Masuk sebagai: <strong class="text-slate-900">{{ auth()->user()->name }}</strong></span>
            <span class="text-slate-300">|</span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-rose-600 hover:text-rose-700 underline font-semibold cursor-pointer">
                    Keluar (Logout)
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 mb-6 rounded-r-lg shadow-sm">
                <p class="text-emerald-700 font-medium">{{ session('success') }}</p>
                <a href="{{ route('laporan.dashboard') }}" class="text-xs text-emerald-600 underline mt-1 inline-block">Buka Dashboard Antrean Admin &rarr;</a>
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