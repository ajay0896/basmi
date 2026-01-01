from fastapi import FastAPI, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel, Field, validator
import joblib
import logging
from datetime import datetime
import re
from typing import List

# Setup logging
logging.basicConfig(
    filename='predictions.log',
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)
logger = logging.getLogger(__name__)

# Load model & vectorizer
try:
    model = joblib.load("models/text_model.pkl")
    vectorizer = joblib.load("models/vectorizer.pkl")
    logger.info("Models loaded successfully")
except Exception as e:
    logger.error(f"Failed to load models: {str(e)}")
    raise

app = FastAPI(title="PungliGuard ML API", version="1.0.0")

# Add CORS middleware
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],  # In production, specify exact origins
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Schema untuk request
class TextIn(BaseModel):
    text: str = Field(..., min_length=15, max_length=5000, description="Teks laporan minimal 15 karakter")

    @validator('text')
    def validate_text(cls, v):
        if not v.strip():
            raise ValueError('Teks tidak boleh kosong')

        # Remove extra whitespaces
        v = re.sub(r'\s+', ' ', v.strip())

        # Check if contains at least some meaningful content (min 3 words instead of 5)
        words = v.split()
        if len(words) < 3:
            raise ValueError('Laporan terlalu pendek, minimal 3 kata')

        return v

valid_keywords = ["pungli", "pemalakan", "korupsi", "preman", 'pajak', 'suap', 'gratifikasi', 'kolusi', 'nepotisme', 'pungutan liar']

# Spam patterns to detect
spam_patterns = [
    r'\b(jual|beli|promo|diskon|bonus)\b.*\b(hubungi|wa|whatsapp)\b',
    r'\b(klik|link|daftar)\b.*\b(sekarang|gratis|murah)\b',
    r'(http://|https://|www\.)',  # URLs often spam
]

def clean_text_for_analysis(text: str) -> str:
    """Remove special chars but keep meaningful content"""
    # Remove URLs
    text = re.sub(r'http\S+|www\.\S+', '', text)
    # Remove excessive punctuation but keep structure
    text = re.sub(r'[^\w\s.,!?-]', '', text)
    # Normalize whitespace
    text = re.sub(r'\s+', ' ', text).strip()
    return text

def check_spam_patterns(text: str) -> tuple[bool, str]:
    """Check for common spam patterns"""
    text_lower = text.lower()

    for pattern in spam_patterns:
        if re.search(pattern, text_lower, re.IGNORECASE):
            return True, f"Terdeteksi pola spam"

    return False, ""

def check_keyword_spam(text: str, keyword: str) -> bool:
    """
    Check if text is keyword spam (user trying to bypass ML by repeating keywords)
    Returns True if it's spam, False if legitimate
    """
    # Clean text untuk analisis yang lebih akurat
    clean = clean_text_for_analysis(text)
    words = clean.lower().split()

    # Hitung berapa kali keyword muncul
    keyword_count = sum(1 for w in words if keyword in w)

    # Jika keyword muncul >30% dari total kata -> spam
    if len(words) > 0 and (keyword_count / len(words)) > 0.3:
        logger.warning(f"Keyword spam detected: '{keyword}' appears {keyword_count}/{len(words)} times")
        return True


    if len(words) < 10:
        logger.warning(f"Text too short after cleaning: {len(words)} words")
        return True

    return False

@app.get("/")
def root():
    return {
        "message": "ML API is running 🚀",
        "version": "1.0.0",
        "endpoints": ["/predict", "/model-info", "/health"]
    }

@app.get("/health")
def health_check():
    """Health check endpoint"""
    return {
        "status": "healthy",
        "timestamp": datetime.now().isoformat(),
        "model_loaded": model is not None
    }

@app.get("/model-info")
def model_info():
    """Get model information"""
    try:
        return {
            "model_type": str(type(model).__name__),
            "vectorizer_type": str(type(vectorizer).__name__),
            "valid_keywords": valid_keywords,
            "min_text_length": 15,
            "min_word_count": 3,
            "max_text_length": 5000,
            "confidence_threshold": 0.6
        }
    except Exception as e:
        logger.error(f"Error getting model info: {str(e)}")
        raise HTTPException(status_code=500, detail="Failed to get model info")



@app.post("/predict")
def predict(data: TextIn):
    """
    Predict if text is valid report or spam
    Returns prediction with confidence score
    """
    start_time = datetime.now()

    try:
        # Preprocessing input
        clean_text = data.text.lower().strip()

        # Check for general spam patterns first
        is_spam_pattern, spam_reason = check_spam_patterns(clean_text)
        if is_spam_pattern:
            logger.warning(f"Spam pattern detected: {spam_reason}")
            return {
                "success": False,
                "text": data.text[:100] + "...",
                "prediction": 0,
                "label": "spam",
                "confidence": 0.92,
                "reason": spam_reason
            }

        # Check for keyword presence
        detected_keyword = None
        for keyword in valid_keywords:
            if keyword in clean_text:
                # Check if it's keyword spam
                if check_keyword_spam(clean_text, keyword):
                    logger.warning(f"Keyword spam rejected: '{keyword}' in text of length {len(clean_text)}")
                    return {
                        "success": False,
                        "text": data.text[:100] + "...",  # Truncate for privacy
                        "prediction": 0,
                        "label": "spam",
                        "confidence": 0.95,
                        "reason": "Terdeteksi spam keyword - laporan terlalu pendek atau terlalu banyak pengulangan kata kunci"
                    }

                detected_keyword = keyword
                break

        # If valid keyword detected without spam
        if detected_keyword:
            processing_time = (datetime.now() - start_time).total_seconds()
            logger.info(f"Keyword match: '{detected_keyword}' | Processing time: {processing_time:.3f}s")

            return {
                "success": True,
                "text": data.text[:100] + "...",
                "prediction": 1,
                "label": "valid",
                "confidence": 0.90,
                "reason": f"Terdeteksi kata kunci '{detected_keyword}'",
                "processing_time": processing_time
            }

        # Use ML model for prediction
        X = vectorizer.transform([clean_text])
        prediction = model.predict(X)[0]

        # Get confidence score if model supports it
        confidence = 0.75  # Default confidence
        if hasattr(model, 'predict_proba'):
            try:
                proba = model.predict_proba(X)[0]
                confidence = float(max(proba))
            except Exception as e:
                logger.warning(f"Could not get probability: {str(e)}")

        # Mapping label
        mapping = {"spam": 0, "valid": 1}
        pred_num = mapping.get(prediction, 0)

        # Low confidence warning
        if confidence < 0.6:
            logger.warning(f"Low confidence prediction: {confidence:.2f} for text: {clean_text[:50]}")

        processing_time = (datetime.now() - start_time).total_seconds()

        # Log prediction
        logger.info(f"ML Prediction: {prediction} | Confidence: {confidence:.2f} | Time: {processing_time:.3f}s")

        return {
            "success": True,
            "text": data.text[:100] + "...",
            "prediction": pred_num,
            "label": prediction,
            "confidence": round(confidence, 2),
            "processing_time": round(processing_time, 3),
            "note": "Prediksi menggunakan ML model" if confidence >= 0.6 else "Confidence rendah, mungkin perlu review manual"
        }

    except ValueError as ve:
        logger.error(f"Validation error: {str(ve)}")
        raise HTTPException(status_code=400, detail=str(ve))

    except Exception as e:
        logger.error(f"Prediction error: {str(e)}")
        raise HTTPException(
            status_code=500,
            detail=f"Terjadi kesalahan saat prediksi: {str(e)}"
        )

# Batch prediction endpoint
class BatchTextIn(BaseModel):
    texts: List[str] = Field(..., min_items=1, max_items=10, description="List of texts to predict (max 10)")

@app.post("/predict/batch")
def predict_batch(data: BatchTextIn):
    """
    Predict multiple texts at once (max 10)
    Returns list of predictions
    """
    start_time = datetime.now()
    results = []

    try:
        for idx, text in enumerate(data.texts):
            # Validate minimum length
            if len(text) < 20:
                results.append({
                    "index": idx,
                    "success": False,
                    "error": "Text too short (min 20 chars)"
                })
                continue

            # Use single prediction logic
            try:
                text_obj = TextIn(text=text)
                pred_result = predict(text_obj)
                results.append({
                    "index": idx,
                    **pred_result
                })
            except Exception as e:
                results.append({
                    "index": idx,
                    "success": False,
                    "error": str(e)
                })

        processing_time = (datetime.now() - start_time).total_seconds()
        logger.info(f"Batch prediction: {len(data.texts)} texts | Time: {processing_time:.3f}s")

        return {
            "success": True,
            "total": len(data.texts),
            "results": results,
            "processing_time": round(processing_time, 3)
        }

    except Exception as e:
        logger.error(f"Batch prediction error: {str(e)}")
        raise HTTPException(status_code=500, detail=str(e))

# Statistics endpoint
@app.get("/stats")
def get_stats():
    """
    Get API statistics from logs
    """
    try:
        import os
        if not os.path.exists('predictions.log'):
            return {"message": "No logs available yet"}

        with open('predictions.log', 'r') as f:
            lines = f.readlines()

        total_predictions = sum(1 for line in lines if 'Prediction:' in line or 'Keyword match:' in line)
        spam_detected = sum(1 for line in lines if 'spam rejected' in line.lower())

        return {
            "total_predictions": total_predictions,
            "spam_blocked": spam_detected,
            "total_logs": len(lines),
            "log_file_size_kb": round(os.path.getsize('predictions.log') / 1024, 2)
        }
    except Exception as e:
        logger.error(f"Stats error: {str(e)}")
        return {"error": str(e)}

if __name__ == "__main__":
    import uvicorn
    uvicorn.run(app, host="0.0.0.0", port=8001)
