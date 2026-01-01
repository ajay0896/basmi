# ML Service - Spam Detection API

FastAPI service untuk deteksi spam/valid text pada laporan pungli.

## Setup

1. Buat virtual environment:

```bash
python -m venv venv
venv\Scripts\activate
```

2. Install dependencies:

```bash
pip install -r requirements.txt
```

3. Copy model files ke folder `models/`:

-   text_model.pkl
-   vectorizer.pkl

## Run Server

```bash
uvicorn main:app --reload --port 8001
```

Server akan berjalan di: http://localhost:8001

## Test Endpoints

### GET /

Health check endpoint

### POST /predict

Request body:

```json
{
    "text": "Saya mau lapor ada pungli di kelurahan"
}
```

Response:

```json
{
    "success": true,
    "text": "Saya mau lapor ada pungli di kelurahan",
    "prediction": 1,
    "label": "valid",
    "note": "Terdeteksi kata kunci 'pungli', otomatis dianggap valid"
}
```
