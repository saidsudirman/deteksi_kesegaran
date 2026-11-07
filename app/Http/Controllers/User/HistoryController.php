<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index(Request $request)
    {
        $histories = $request->user()
            ->detectionHistories()
            ->latest()
            ->paginate(10);

        return view('user.history.index', compact('histories'));
    }

    public function show(Request $request, $id)
    {
        $history = $request->user()
            ->detectionHistories()
            ->findOrFail($id);

        return view('user.history.show', compact('history'));
    }
}
