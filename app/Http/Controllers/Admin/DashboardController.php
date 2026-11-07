<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DetectionHistory;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengguna = User::where('role', 'user')->count();

        $totalDeteksi = DetectionHistory::count();

        $hasilSegar = DetectionHistory::where(
            'hasil_prediksi',
            'Segar'
        )->count();

        $tidakSegar = DetectionHistory::where(
            'hasil_prediksi',
            'Tidak_Segar'
        )->count();

        $aktivitasTerbaru = DetectionHistory::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'totalDeteksi',
            'hasilSegar',
            'tidakSegar',
            'aktivitasTerbaru'
        ));
    }
}
