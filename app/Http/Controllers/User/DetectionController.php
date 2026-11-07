<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DetectionHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Client\ConnectionException;

class DetectionController extends Controller
{
    public function index()
    {
        return view('user.detection');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
            'jenis_objek' => 'required|in:buah,sayuran',
        ]);

        $imagePath = null;

        try {
            $image = $request->file('image');

            $response = Http::timeout(120)
                ->attach(
                    'file',
                    file_get_contents($image->getRealPath()),
                    $image->getClientOriginalName()
                )
                ->post(config('services.freshai.url') . '/predict');

            if (!$response->successful()) {
                return back()->withErrors([
                    'image' => 'AI gagal memproses gambar. Silakan coba kembali.'
                ])->withInput();
            }

            $result = $response->json();

            if (!is_array($result) || !isset($result['status'])) {
                return back()->withErrors([
                    'image' => 'Respons dari AI tidak valid.'
                ])->withInput();
            }

            if ($result['status'] === 'rejected') {
                return back()->withErrors([
                    'image' => $result['pesan'] ?? 'Gambar bukan buah atau sayuran. Silakan unggah gambar yang sesuai.'
                ])->withInput();
            }

            if (
                $result['status'] !== 'success' ||
                !isset($result['hasil_prediksi']) ||
                !isset($result['confidence']) ||
                !is_numeric($result['confidence'])
            ) {
                return back()->withErrors([
                    'image' => 'Data hasil deteksi dari AI tidak lengkap atau tidak valid.'
                ])->withInput();
            }

            $imagePath = $image->store('detections', 'public');

            $history = $request->user()->detectionHistories()->create([
                'image_path' => $imagePath,
                'jenis_objek' => $request->jenis_objek,
                'hasil_prediksi' => $result['hasil_prediksi'],
                'confidence' => $result['confidence'],
                'probabilitas' => $result['probabilitas'] ?? null,
            ]);

            $result['jenis_objek'] = $request->jenis_objek;
            $result['detection_id'] = $history->id;

            return back()
                ->with('success', 'Deteksi kesegaran berhasil dan riwayat telah disimpan!')
                ->with('detection_result', $result);

        } catch (ConnectionException $e) {
            return back()->withErrors([
                'image' => 'Tidak dapat terhubung ke server AI. Pastikan FastAPI sedang berjalan.'
            ])->withInput();

        } catch (\Throwable $e) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            report($e);

            return back()->withErrors([
                'image' => 'Terjadi kesalahan saat menyimpan hasil deteksi.'
            ])->withInput();
        }
    }
}