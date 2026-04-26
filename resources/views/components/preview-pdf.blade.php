<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Preview Dokumen' }} - Perpustakaan Digital</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            background: #0f0f23;
            color: #e2e8f0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* ===== TOOLBAR ===== */
        .toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 24px;
            background: linear-gradient(135deg, #1a1a3e 0%, #16213e 100%);
            border-bottom: 1px solid rgba(99, 102, 241, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            flex-shrink: 0;
            z-index: 10;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .toolbar-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .toolbar-icon svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .toolbar-title {
            font-size: 16px;
            font-weight: 700;
            color: #f1f5f9;
            letter-spacing: -0.01em;
        }

        .toolbar-subtitle {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 1px;
            letter-spacing: 0.5px;
        }

        .toolbar-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 12px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            border: none;
            transition: all 0.2s ease;
            letter-spacing: 0.3px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .btn-back {
            background: rgba(255, 255, 255, 0.06);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .btn-back:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #f1f5f9;
        }

        .btn-download {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-download:hover {
            background: linear-gradient(135deg, #4f46e5, #7c3aed);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
        }

        .btn svg {
            width: 16px;
            height: 16px;
        }

        /* ===== PDF VIEWER ===== */
        .pdf-container {
            flex: 1;
            background: #1e1e3a;
            position: relative;
            overflow: hidden;
        }

        .pdf-container iframe {
            width: 100%;
            height: 100%;
            border: none;
            background: #fff;
        }

        /* ===== LOADING STATE ===== */
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: #1e1e3a;
            z-index: 5;
            transition: opacity 0.4s ease;
        }

        .loading-overlay.hidden {
            opacity: 0;
            pointer-events: none;
        }

        .loading-spinner {
            width: 48px;
            height: 48px;
            border: 4px solid rgba(99, 102, 241, 0.2);
            border-top-color: #6366f1;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin-bottom: 16px;
        }

        .loading-text {
            font-size: 14px;
            font-weight: 600;
            color: #94a3b8;
            letter-spacing: 0.5px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .toolbar {
                padding: 10px 16px;
                flex-wrap: wrap;
                gap: 10px;
            }

            .toolbar-title {
                font-size: 14px;
            }

            .toolbar-subtitle {
                font-size: 10px;
            }

            .toolbar-actions {
                width: 100%;
                justify-content: stretch;
            }

            .btn {
                flex: 1;
                justify-content: center;
                padding: 10px 14px;
                font-size: 12px;
            }

            .toolbar-icon {
                width: 36px;
                height: 36px;
                border-radius: 10px;
            }

            .toolbar-icon svg {
                width: 18px;
                height: 18px;
            }
        }
    </style>
</head>
<body>
    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-left">
            <div class="toolbar-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>
            </div>
            <div>
                <div class="toolbar-title">{{ $title ?? 'Preview Dokumen' }}</div>
                <div class="toolbar-subtitle">Preview sebelum download • Perpustakaan Digital</div>
            </div>
        </div>
        <div class="toolbar-actions">
            <a href="{{ $backUrl }}" class="btn btn-back">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Kembali
            </a>
            <a href="{{ $downloadUrl }}" class="btn btn-download">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Download PDF
            </a>
        </div>
    </div>

    <!-- PDF Viewer -->
    <div class="pdf-container">
        <div class="loading-overlay" id="loadingOverlay">
            <div class="loading-spinner"></div>
            <div class="loading-text">Memuat preview dokumen...</div>
        </div>
        <iframe src="{{ $streamUrl }}" id="pdfFrame" onload="document.getElementById('loadingOverlay').classList.add('hidden')"></iframe>
    </div>
</body>
</html>
