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

    // Menampilkan halaman dashboard admin dengan urutan urgensi teratas
    public function dashboard()
    {
        // Diurutkan berdasarkan prioritas: Tinggi -> Sedang -> Rendah
        $laporans = Laporan::orderByRaw("FIELD(urgensi, 'Tinggi', 'Sedang', 'Rendah') ASC")
                            ->orderBy('created_at', 'DESC')
                            ->get();

        return view('laporan.dashboard', compact('laporans'));
    }
}