@extends('layouts.user')

@section('title', 'Deteksi Kesegaran')

@section('content')
<div class="mb-4">
    <h3 class="fw-bold">Deteksi Kesegaran</h3>
    <p class="text-secondary">
        Unggah foto buah atau sayuran untuk mengetahui tingkat kesegarannya menggunakan AI.
    </p>
</div>

<div class="card content-card p-4">
    @if (session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">
                <i class="fas fa-exclamation-circle me-2"></i>
                Deteksi tidak dapat dilanjutkan
            </div>

            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    <form
        action="{{ route('user.detection.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="mb-4">
            <label class="form-label fw-semibold">Jenis Objek</label>

            <select name="jenis_objek" class="form-select" required>
                <option value="">Pilih jenis objek</option>
                <option value="buah" {{ old('jenis_objek') == 'buah' ? 'selected' : '' }}>
                    Buah
                </option>
                <option value="sayuran" {{ old('jenis_objek') == 'sayuran' ? 'selected' : '' }}>
                    Sayuran
                </option>
            </select>
        </div>

        <div class="mb-4">
            <label class="form-label fw-semibold">
                Foto Buah atau Sayuran
            </label>

            <input
                type="file"
                name="image"
                id="imageInput"
                class="form-control"
                accept="image/jpeg,image/png,image/webp"
                required
                onchange="previewImage(event)"
            >

            <small class="text-secondary">
                Format JPG, JPEG, PNG, atau WEBP. Maksimal 5 MB.
            </small>
        </div>

        <div class="mb-4">
            <img
                id="imagePreview"
                src=""
                class="img-fluid rounded d-none"
                style="max-height: 300px;"
                alt="Preview gambar"
            >
        </div>

        <button type="submit" class="btn btn-fresh px-4">
            <i class="fas fa-brain me-2"></i>
            Deteksi Kesegaran
        </button>
    </form>
</div>

@if (session('detection_result'))
    @php
        $result = session('detection_result');

        $statusColors = [
            'Segar' => 'success',
            'Cukup_Segar' => 'info',
            'Kurang_Segar' => 'warning',
            'Tidak_Segar' => 'danger',
        ];

        $statusLabels = [
            'Segar' => 'Segar',
            'Cukup_Segar' => 'Cukup Segar',
            'Kurang_Segar' => 'Kurang Segar',
            'Tidak_Segar' => 'Tidak Segar',
        ];

        $predictedClass = $result['hasil_prediksi'] ?? '-';
        $color = $statusColors[$predictedClass] ?? 'secondary';
        $confidence = (float) ($result['confidence'] ?? 0);
        $confidenceValidasi = (float) ($result['confidence_validasi'] ?? 0);
    @endphp

    <div class="card content-card p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
            <h4 class="fw-bold mb-0">Hasil Deteksi AI</h4>

            <span class="badge bg-{{ $color }} fs-6">
                {{ $statusLabels[$predictedClass] ?? $predictedClass }}
            </span>
        </div>

        <div class="alert alert-success">
            <i class="fas fa-check-circle me-2"></i>
            Gambar berhasil melewati validasi objek dan telah diklasifikasikan oleh AI.
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <h6 class="fw-semibold">Jenis Objek</h6>
                <p class="text-secondary">
                    {{ ucfirst($result['jenis_objek'] ?? '-') }}
                </p>

                <h6 class="fw-semibold">Validasi Objek</h6>
                <p class="text-success fw-semibold">
                    <i class="fas fa-check-circle me-1"></i>
                    Buah atau Sayuran
                </p>

                <h6 class="fw-semibold">Confidence Validasi Objek</h6>
                <h4 class="fw-bold">
                    {{ number_format($confidenceValidasi, 2) }}%
                </h4>

                <div class="progress mb-4" style="height: 10px;">
                    <div
                        class="progress-bar bg-success"
                        role="progressbar"
                        style="width: {{ min(100, max(0, $confidenceValidasi)) }}%"
                    ></div>
                </div>

                <h6 class="fw-semibold">Hasil Prediksi Kesegaran</h6>
                <h3 class="fw-bold text-{{ $color }}">
                    {{ $statusLabels[$predictedClass] ?? $predictedClass }}
                </h3>

                <h6 class="fw-semibold mt-3">Confidence Kesegaran</h6>
                <h4 class="fw-bold">
                    {{ number_format($confidence, 2) }}%
                </h4>

                <div class="progress" style="height: 12px;">
                    <div
                        class="progress-bar bg-{{ $color }}"
                        role="progressbar"
                        style="width: {{ min(100, max(0, $confidence)) }}%"
                    ></div>
                </div>
            </div>

            <div class="col-md-6">
                <h6 class="fw-semibold mb-3">
                    Probabilitas Setiap Kategori Kesegaran
                </h6>

                @foreach ($result['probabilitas'] ?? [] as $label => $probability)
                    @php
                        $probabilityColor = $statusColors[$label] ?? 'secondary';
                    @endphp

                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small class="fw-semibold">
                                {{ $statusLabels[$label] ?? $label }}
                            </small>

                            <small>
                                {{ number_format((float) $probability, 2) }}%
                            </small>
                        </div>

                        <div class="progress" style="height: 9px;">
                            <div
                                class="progress-bar bg-{{ $probabilityColor }}"
                                role="progressbar"
                                style="width: {{ min(100, max(0, (float) $probability)) }}%"
                            ></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="alert alert-info mt-4 mb-0">
            <i class="fas fa-info-circle me-2"></i>
            Hasil merupakan prediksi model AI berdasarkan gambar yang diunggah.
            Tingkat keyakinan AI tidak selalu menunjukkan kondisi kesegaran
            sebenarnya sehingga hasil dapat berbeda dari pemeriksaan langsung.
        </div>
    </div>
@endif

<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];

        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('d-none');
        } else {
            preview.src = '';
            preview.classList.add('d-none');
        }
    }
</script>
@endsection
