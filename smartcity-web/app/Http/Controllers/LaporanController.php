<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LaporanController extends Controller
{
    // Menampilkan halaman formulir untuk masyarakat
    public function index()
    {
        return view('laporan.index');
    }

    // Memproses input formulir dan menembak API AI Python
    public function store(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string', 
            'judul' => 'required|string',
            'isi_laporan' => 'required|string',
            'lokasi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        // Handle Upload Foto Bukti
        $namaFoto = null;
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            // Membuat nama file unik berdasarkan timestamp
            $namaFoto = time() . '_' . $file->getClientOriginalName();
            // Menyimpan gambar ke folder public/uploads/laporan
            $file->move(public_path('uploads/laporan'), $namaFoto);
        }

        $urgensi = 'Rendah'; // Nilai default jika API AI offline
        $confidenceScore = 0.0;

        try {
            // Mengirim teks ke API Python FastAPI di port 5000
            $response = Http::post('http://127.0.0.1:5000/predict', [
                'text' => $request->judul . ' ' . $request->isi_laporan
            ]);

            if ($response->successful()) {
                $urgensi = $response->json('prediction');
                $confidenceScore = $response->json('confidence_score');
            }
        } catch (\Exception $e) {
            // Jika python belum dinyalakan, log error tapi web tetap menyimpan data
            logger("Gagal terhubung ke API AI: " . $e->getMessage());
        }

        // Simpan ke database MySQL AMPPS
        Laporan::create([
            'user_id' => auth()->id(),
            'instansi' => $request->instansi, 
            'judul' => $request->judul, 
            'isi_laporan' => $request->isi_laporan,
            'lokasi' => $request->lokasi,
            'foto' => $namaFoto, 
            'urgensi' => $urgensi,
            'confidence_score' => $confidenceScore,
            'status' => 'Masuk'
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil terkirim dan otomatis dianalisis AI!');
    }

    // Menampilkan riwayat laporan khusus untuk user/masyarakat yang sedang login
    public function riwayatUser()
    {
        // Mengambil laporan milik user ini saja, diurutkan dari yang terbaru
        $laporans = Laporan::where('user_id', auth()->id())
                            ->latest()
                            ->get();

        return view('laporan.riwayat', compact('laporans'));
    }

    // Menampilkan halaman dashboard admin dengan urutan urgensi teratas (Filtered by Instansi)
    public function dashboard()
    {
        // 1. Ambil data admin yang sedang login
        $user = auth()->user();

        // 2. Siapkan query dasar dengan pengurutan (Prioritas AI & Tanggal Terbaru)
        $query = Laporan::orderByRaw("FIELD(urgensi, 'Tinggi', 'Sedang', 'Rendah') ASC")
                        ->orderBy('created_at', 'DESC');

        // 3. Jalankan logika filter berdasarkan Role
        if ($user->role === 'superadmin') {
            // Jika Superadmin, ambil semua data laporan
            $laporans = $query->get();
        } elseif ($user->role === 'admin_instansi') {
            // Jika Admin Instansi, filter dulu berdasarkan nama instansi baru jalankan get()
            $laporans = $query->where('instansi', $user->instansi)->get();
        } else {
            // Jika user biasa usil nembak url dashboard, tendang balik
            return redirect()->route('laporan.index')->with('error', 'Akses ditolak.');
        }

        // 4. Kirim data ke view dashboard admin
        return view('laporan.dashboard', compact('laporans'));
    }

    public function statistik()
    {
        $user = auth()->user();
        $query = Laporan::query();
        
        // Filter jika hanya admin instansi
        if ($user->role === 'admin_instansi') {
            $query->where('instansi', $user->instansi);
        } elseif ($user->role !== 'superadmin') {
            return redirect()->route('laporan.index')->with('error', 'Akses ditolak.');
        }

        // 1. Hitung total data murni untuk Card Ringkasan
        $totalSemua   = (clone $query)->count();
        $totalMasuk   = (clone $query)->where('status', 'Masuk')->count();
        $totalDiproses = (clone $query)->where('status', 'Diproses')->count();
        $totalSelesai  = (clone $query)->where('status', 'Selesai')->count();

        // 2. Data tambahan: Rincian kontribusi per instansi untuk keterangan Kontrol Global
        $laporanPerInstansi = [];
        if ($user->role === 'superadmin') {
            $laporanPerInstansi = Laporan::selectRaw('instansi, count(*) as total')
                                        ->groupBy('instansi')
                                        ->orderBy('total', 'desc')
                                        ->get();
        }

        // Kirim semua variabel ke view
        return view('laporan.statistik', compact(
            'totalSemua', 
            'totalMasuk', 
            'totalDiproses', 
            'totalSelesai',
            'laporanPerInstansi'
        ));
    }

    // Memproses perubahan status laporan oleh admin instansi
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string|in:Masuk,Diproses,Selesai',
        ]);

        // Cari laporannya berdasarkan ID
        $laporan = Laporan::findOrFail($id);
        $user = auth()->user();

        // Keamanan tambahan: Pastikan admin instansi hanya bisa update laporan milik instansinya sendiri
        if ($user->role === 'admin_instansi' && $laporan->instansi !== $user->instansi) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk mengubah laporan ini.');
        }

        // Update status laporan
        $laporan->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success_status', 'Status laporan berhasil diperbarui menjadi: ' . $request->status);
    }
}