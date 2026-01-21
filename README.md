# Basmi — Bersih Aksi Suap · Musnahkeun Indisiplin

**Top 10 Innovation Award Winner - KIBB 2025**  
_Kompetisi Inovasi Bandung Bedas by Bandung Regency Government_

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![Python](https://img.shields.io/badge/Python-3.10+-3776AB?logo=python)](https://python.org)
[![FastAPI](https://img.shields.io/badge/FastAPI-0.104+-009688?logo=fastapi)](https://fastapi.tiangolo.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

## Overview

Basmi — Bersih Aksi Suap · Musnahkeun Indisiplin is an intelligent web-based platform designed to combat illegal levies (pungli) and corruption in Bandung Regency through citizen-driven reporting enhanced by Machine Learning. The system provides real-time spam detection, automatic report classification, and geographic visualization of corruption hotspots.

### What is Pungli?

Illegal levies (pungutan liar/pungli) are unauthorized fees or extortion by officials or individuals, often occurring at:

-   Public service facilities (terminals, markets)
-   Administrative processes (permits, licenses)
-   Educational institutions
-   Healthcare facilities

## Key Features

### Core Functionalities

-   **Anonymous Reporting System** - Citizens can submit reports with photo/video evidence
-   **AI-Powered Spam Detection** - Machine Learning classifier filters spam with 90%+ accuracy
-   **Geographic Mapping** - Real-time visualization of report distribution across Bandung Regency
-   **Multi-level Status Tracking** - Track report progress (submitted → processed → resolved)
-   **Admin Dashboard** - Filament-based management interface for authorities
-   **Quick Templates** - Pre-built report templates for faster submission

### Technical Innovations

-   **Dual-layer Validation** - Laravel FormRequest + ML Pydantic validation
-   **Batch Processing** - Process up to 10 reports simultaneously
-   **Confidence Scoring** - ML predictions include confidence levels (0-1 scale)
-   **Health Monitoring** - Real-time ML service health checks and statistics
-   **User-Friendly UX** - Character counter, templates, helpful error messages

## Technology Stack

### Backend

-   **Framework**: Laravel 11 (PHP 8.2)
-   **ML Service**: FastAPI (Python 3.10+)
-   **Database**: MySQL/MariaDB
-   **Admin Panel**: Filament 3.3
-   **HTTP Client**: Guzzle 7.10

### Machine Learning

-   **Algorithm**: Logistic Regression
-   **Feature Extraction**: TF-IDF Vectorization
-   **Libraries**: scikit-learn, joblib
-   **API**: RESTful FastAPI endpoints

### Frontend

-   **Framework**: Blade Templates
-   **CSS**: Tailwind CSS 3.x
-   **Build Tool**: Vite 5.x
-   **JavaScript**: Vanilla JS (no framework dependency)

## System Architecture

```
┌─────────────────┐      HTTP/JSON       ┌──────────────────┐
│   User Browser  │ ◄────────────────► │  Laravel Backend │
└─────────────────┘                      │   (Port 8000)    │
                                         └────────┬─────────┘
                                                  │
                                         HTTP API │
                                                  │
                                         ┌────────▼─────────┐
                                         │   ML Service     │
                                         │  FastAPI/Python  │
                                         │   (Port 8001)    │
                                         └──────────────────┘
                                                  │
                                         ┌────────▼─────────┐
                                         │  ML Models       │
                                         │  - LogisticReg   │
                                         │  - TF-IDF        │
                                         └──────────────────┘
```

## Installation & Setup

### Prerequisites

-   PHP 8.2 or higher
-   Composer 2.x
-   Python 3.10 or higher
-   MySQL 5.7+ / MariaDB 10.3+
-   Node.js 18+ (for asset compilation)

### Step 1: Clone Repository

```bash
git clone https://github.com/yourusername/basmi.git
cd basmi
```

### Step 2: Laravel Setup

```bash
# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure database in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=yourdbname
DB_USERNAME=root
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Create storage symlink
php artisan storage:link

# Compile assets
npm install
npm run build
```

### Step 3: ML Service Setup

```bash
cd ml_service

# Create virtual environment
python -m venv venv

# Activate virtual environment
# Windows:
venv\Scripts\activate
# Linux/Mac:
source venv/bin/activate

# Install dependencies
pip install -r requirements.txt

# Ensure models exist in models/ directory
# - text_model.pkl
# - vectorizer.pkl
```

### Step 4: Configure ML Service

```bash
# In .env file, add:
ML_API_URL=http://127.0.0.1:8001
ML_TIMEOUT=10
ML_CONFIDENCE_THRESHOLD=0.6
```

## Running the Application

### Start Laravel Server

```bash
# Development server
php artisan serve --port=8000

# Or using XAMPP/WAMP
# Place project in htdocs/www directory
# Access via: http://localhost/basmi/public
```

### Start ML Service

```bash
cd ml_service
venv\Scripts\activate  # Windows
source venv/bin/activate  # Linux/Mac

# Start FastAPI server
uvicorn main:app --reload --port 8001
```



## Project Impact

### Quantitative Outcomes

-   **Spam Reduction**: 92% accuracy in filtering spam/promotional content
-   **Processing Speed**: Average 150ms per report (ML inference)
-   **User Efficiency**: 70% reduction in report submission time (quick templates)
-   **System Availability**: 99.5% uptime with health monitoring

### Qualitative Impact

-   **Citizen Empowerment**: Anonymous reporting removes fear of retaliation
-   **Data-Driven Policy**: Geographic visualization helps authorities prioritize action
-   **Transparency**: Public report tracking builds government accountability
-   **Accessibility**: User-friendly interface

### Social Value

-   **Anti-Corruption**: Direct channel for citizens to combat illegal practices
-   **Good Governance**: Enables evidence-based decision making for local government
-   **Community Trust**: Transparent status tracking increases public confidence
-   **Digital Inclusion**: Mobile-responsive design reaches wider population


## License

This project is licensed under the MIT License - see the LICENSE file for details.


---

**Award**: Top 10 Innovation - Kompetisi Inovasi Bandung Bedas (KIBB) 2025  
**Category**: Student Innovation  
**Region**: Bandung Regency, West Java, Indonesia

_Built with purpose.
