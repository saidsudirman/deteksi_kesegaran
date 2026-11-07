<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetectionHistory;
use Illuminate\Http\Request;

class DetectionHistoryController extends Controller
{
    public function index(Request $request)
    {
        $histories = DetectionHistory::with('user')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_objek', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->jenis_objek, function ($query, $jenis) {
                $query->where('jenis_objek', $jenis);
            })
            ->when($request->hasil_prediksi, function ($query, $hasil) {
                $query->where('hasil_prediksi', $hasil);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.detection-histories.index', compact('histories'));
    }

    public function show(DetectionHistory $detectionHistory)
    {
        $detectionHistory->load('user');

        return view(
            'admin.detection-histories.show',
            compact('detectionHistory')
        );
    }
}
