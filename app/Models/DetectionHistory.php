<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetectionHistory extends Model
{
    protected $fillable = [
        'user_id',
        'image_path',
        'jenis_objek',
        'nama_objek',
        'hasil_prediksi',
        'confidence',
        'probabilitas',
    ];

    protected function casts(): array
    {
        return [
            'confidence' => 'decimal:2',
            'probabilitas' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}