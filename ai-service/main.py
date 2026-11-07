
import os
import io
import numpy as np
import tensorflow as tf

from PIL import Image
from fastapi import FastAPI, File, UploadFile, HTTPException
from tensorflow.keras.applications.mobilenet_v2 import preprocess_input

app = FastAPI(
    title="FreshAI Detection API",
    description="API Validasi Objek dan Deteksi Kesegaran Buah dan Sayuran",
    version="2.0.0"
)

BASE_DIR = os.path.dirname(os.path.abspath(__file__))
MODEL_DIR = os.path.join(BASE_DIR, "models")

FRESHNESS_MODEL_PATH = os.path.join(MODEL_DIR, "best_model.keras")
OBJECT_MODEL_PATH = os.path.join(MODEL_DIR, "object_validator.keras")

CLASS_NAMES = [
    "Segar",
    "Cukup_Segar",
    "Kurang_Segar",
    "Tidak_Segar"
]

OBJECT_CLASS_NAMES = [
    "buah_sayuran",
    "bukan_buah_sayuran"
]

OBJECT_THRESHOLD = 0.5

object_model = tf.keras.models.load_model(OBJECT_MODEL_PATH)
freshness_model = tf.keras.models.load_model(FRESHNESS_MODEL_PATH)


@app.get("/")
def home():
    return {
        "status": "success",
        "message": "FreshAI Detection API berjalan",
        "models": {
            "object_validator": "loaded",
            "freshness_classifier": "loaded"
        }
    }


@app.get("/health")
def health():
    return {
        "status": "healthy",
        "object_model_loaded": object_model is not None,
        "freshness_model_loaded": freshness_model is not None
    }


@app.post("/predict")
async def predict(file: UploadFile = File(...)):

    if file.content_type not in [
        "image/jpeg",
        "image/png",
        "image/webp"
    ]:
        raise HTTPException(
            status_code=400,
            detail="Format gambar tidak didukung"
        )

    try:
        contents = await file.read()

        if len(contents) > 5 * 1024 * 1024:
            raise HTTPException(
                status_code=400,
                detail="Ukuran gambar maksimal 5 MB"
            )

        image = Image.open(io.BytesIO(contents)).convert("RGB")
        image = image.resize((224, 224))

        image_array = np.array(image, dtype=np.float32)
        image_array = np.expand_dims(image_array, axis=0)
        image_array = preprocess_input(image_array)

        # TAHAP 1: VALIDASI OBJEK
        object_predictions = object_model.predict(
            image_array,
            verbose=0
        )[0]

        object_index = int(np.argmax(object_predictions))
        object_confidence = float(object_predictions[object_index])

        # Tolak jika kelas bukan buah/sayuran
        if (
            object_index == 1
            or object_confidence < OBJECT_THRESHOLD
        ):
            return {
                "status": "rejected",
                "validasi_objek": "bukan_buah_sayuran",
                "pesan": "Gambar tidak terdeteksi sebagai buah atau sayuran. Silakan unggah gambar buah atau sayuran.",
                "confidence_validasi": round(
                    object_confidence * 100, 2
                )
            }

        # TAHAP 2: DETEKSI KESEGARAN
        predictions = freshness_model.predict(
            image_array,
            verbose=0
        )[0]

        predicted_index = int(np.argmax(predictions))
        confidence = float(predictions[predicted_index]) * 100

        return {
            "status": "success",
            "validasi_objek": "buah_sayuran",
            "confidence_validasi": round(
                object_confidence * 100, 2
            ),
            "hasil_prediksi": CLASS_NAMES[predicted_index],
            "confidence": round(confidence, 2),
            "probabilitas": {
                CLASS_NAMES[i]: round(
                    float(predictions[i]) * 100, 2
                )
                for i in range(len(CLASS_NAMES))
            }
        }

    except HTTPException:
        raise

    except Exception as e:
        raise HTTPException(
            status_code=500,
            detail=f"Gagal memproses gambar: {str(e)}"
        )
