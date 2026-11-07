<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $totalDeteksi = $user->detectionHistories()->count();

        $totalSegar = $user->detectionHistories()
            ->where('hasil_prediksi', 'Segar')
            ->count();

        $totalTidakSegar = $user->detectionHistories()
            ->where('hasil_prediksi', 'Tidak_Segar')
            ->count();

        $deteksiTerakhir = $user->detectionHistories()
            ->latest()
            ->first();

        return view('user.dashboard', compact(
            'totalDeteksi',
            'totalSegar',
            'totalTidakSegar',
            'deteksiTerakhir'
        ));
    }
}
