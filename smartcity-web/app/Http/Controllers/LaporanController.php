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

    // Memproses input formulir dan menembak API AI
    public function store(Request $request)
    {
        $request->validate([
            'instansi' => 'required|string',
            'judul' => 'required|string',
            'isi_laporan' => 'required|string',
            'lokasi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Upload foto
        $namaFoto = null;

        if ($request->hasFile('foto')) {

            $file = $request->file('foto');

            $namaFoto = time() . '_' . $file->getClientOriginalName();

            $file->move(
                public_path('uploads/laporan'),
                $namaFoto
            );
        }

        // Default jika AI gagal
        $urgensi = 'Rendah';

        $confidenceScore = 0.0;

        try {

            // Panggil AI Railway
            $response = Http::withoutVerifying()
                ->timeout(60)
                ->post(
                    'https://reporta-ai.up.railway.app/predict',
                    [
                        'text' => $request->judul . ' ' . $request->isi_laporan
                    ]
                );

            // Simpan response untuk debugging
            logger($response->body());

            if ($response->successful()) {

                $urgensi = $response->json('prediction');

                $confidenceScore = $response->json('confidence_score');
            }

        } catch (\Exception $e) {

            logger(
                'Gagal terhubung ke API AI: '
                . $e->getMessage()
            );
        }

        // Simpan ke database
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

        return redirect()
            ->back()
            ->with(
                'success',
                'Laporan berhasil terkirim dan otomatis dianalisis AI!'
            );
    }

    // Riwayat laporan user
    public function riwayatUser()
    {
        $laporans = Laporan::where(
                        'user_id',
                        auth()->id()
                    )
                    ->latest()
                    ->get();

        return view(
            'laporan.riwayat',
            compact('laporans')
        );
    }

    // Dashboard admin
    public function dashboard()
    {
        $user = auth()->user();

        $query = Laporan::orderByRaw(
                    "FIELD(urgensi, 'Tinggi', 'Sedang', 'Rendah') ASC"
                )
                ->orderBy(
                    'created_at',
                    'DESC'
                );

        if ($user->role === 'superadmin') {

            $laporans = $query->get();

        } elseif ($user->role === 'admin_instansi') {

            $laporans = $query
                        ->where(
                            'instansi',
                            $user->instansi
                        )
                        ->get();

        } else {

            return redirect()
                    ->route('laporan.index')
                    ->with(
                        'error',
                        'Akses ditolak.'
                    );
        }

        return view(
            'laporan.dashboard',
            compact('laporans')
        );
    }

    public function statistik()
    {
        $user = auth()->user();

        $query = Laporan::query();

        if ($user->role === 'admin_instansi') {

            $query->where(
                'instansi',
                $user->instansi
            );

        } elseif ($user->role !== 'superadmin') {

            return redirect()
                    ->route('laporan.index')
                    ->with(
                        'error',
                        'Akses ditolak.'
                    );
        }

        $totalSemua = (clone $query)->count();

        $totalMasuk = (clone $query)
                        ->where(
                            'status',
                            'Masuk'
                        )
                        ->count();

        $totalDiproses = (clone $query)
                        ->where(
                            'status',
                            'Diproses'
                        )
                        ->count();

        $totalSelesai = (clone $query)
                        ->where(
                            'status',
                            'Selesai'
                        )
                        ->count();

        $laporanPerInstansi = [];

        if ($user->role === 'superadmin') {

            $laporanPerInstansi = Laporan::selectRaw(
                                    'instansi, count(*) as total'
                                )
                                ->groupBy(
                                    'instansi'
                                )
                                ->orderBy(
                                    'total',
                                    'desc'
                                )
                                ->get();
        }

        return view(
            'laporan.statistik',
            compact(
                'totalSemua',
                'totalMasuk',
                'totalDiproses',
                'totalSelesai',
                'laporanPerInstansi'
            )
        );
    }

    // Update status laporan
    public function updateStatus(
        Request $request,
        $id
    )
    {
        $request->validate([
            'status' =>
            'required|string|in:Masuk,Diproses,Selesai',
        ]);

        $laporan = Laporan::findOrFail($id);

        $user = auth()->user();

        if (
            $user->role === 'admin_instansi'
            &&
            $laporan->instansi !== $user->instansi
        ) {

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Anda tidak memiliki akses untuk mengubah laporan ini.'
                );
        }

        $laporan->update([

            'status' => $request->status

        ]);

        return redirect()
            ->back()
            ->with(
                'success_status',
                'Status laporan berhasil diperbarui menjadi: '
                . $request->status
            );
    }
}