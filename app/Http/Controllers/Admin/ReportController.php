<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetectionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'date_from' => ['nullable', 'date', 'before_or_equal:date_to'],
            'date_to' => ['nullable', 'date', 'after_or_equal:date_from'],
        ]);

        $baseQuery = DetectionHistory::query()
            ->when($validated['date_from'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($validated['date_to'] ?? null, function ($query, $date) {
                $query->whereDate('created_at', '<=', $date);
            });

        $totalDetections = (clone $baseQuery)->count();

        $fruitCount = (clone $baseQuery)
            ->where('jenis_objek', 'buah')
            ->count();

        $vegetableCount = (clone $baseQuery)
            ->where('jenis_objek', 'sayuran')
            ->count();

        $classLabels = [
            'Segar',
            'Cukup_Segar',
            'Kurang_Segar',
            'Tidak_Segar',
        ];

        $classCounts = (clone $baseQuery)
            ->select('hasil_prediksi', DB::raw('COUNT(*) as total'))
            ->groupBy('hasil_prediksi')
            ->pluck('total', 'hasil_prediksi');

        $predictionCounts = collect($classLabels)
            ->map(fn ($label) => (int) ($classCounts[$label] ?? 0))
            ->values();

        $dailyData = (clone $baseQuery)
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('tanggal')
            ->get();

        $averageConfidence = (clone $baseQuery)->avg('confidence') ?? 0;

        $recentHistories = (clone $baseQuery)
            ->with('user')
            ->latest()
            ->limit(5)
            ->get();

        return view('admin.reports.index', compact(
            'totalDetections',
            'fruitCount',
            'vegetableCount',
            'classLabels',
            'predictionCounts',
            'dailyData',
            'averageConfidence',
            'recentHistories'
        ));
    }
}
