@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.scan_qr') }}
    @parent
@stop

{{-- Allow camera access for QR scanner --}}
@push('meta')
    <meta http-equiv="Permissions-Policy" content="camera=(self)">
@endpush

@section('header_right')
    <a href="{{ route('hardware.index') }}" class="btn btn-primary pull-right">
        <x-icon type="arrow-left" /> {{ trans('general.back') }}
    </a>
@stop

{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">
                        <x-icon type="qrcode" /> {{ trans('general.scan_qr') }}
                    </h2>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- Main Options -->
                            <div id="main-options" class="text-center" style="margin-bottom: 30px;">
                                <h4 style="margin-bottom: 20px;">Pilih Metode Scan:</h4>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="panel panel-primary">
                                            <div class="panel-body text-center" style="padding: 30px 15px;">
                                                <i class="fas fa-file-image"
                                                    style="font-size: 48px; margin-bottom: 15px;"></i>
                                                <h4>Upload Gambar</h4>
                                                <p class="text-muted">Upload foto QR Code dari galeri</p>
                                                <button class="btn btn-primary btn-lg"
                                                    onclick="document.getElementById('qr-file-input').click()">
                                                    <i class="fas fa-upload"></i> Pilih Gambar
                                                </button>
                                                <input type="file" id="qr-file-input" accept="image/*"
                                                    style="display: none;" onchange="scanFromFile(this)">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel panel-success">
                                            <div class="panel-body text-center" style="padding: 30px 15px;">
                                                <i class="fas fa-camera" style="font-size: 48px; margin-bottom: 15px;"></i>
                                                <h4>Scan dengan Kamera</h4>
                                                <p class="text-muted">Gunakan kamera untuk scan langsung</p>
                                                <button class="btn btn-success btn-lg" onclick="startCameraScanner()">
                                                    <i class="fas fa-camera"></i> Buka Kamera
                                                </button>
                                                <small class="text-warning" style="display: block; margin-top: 10px;">
                                                    <i class="fas fa-info-circle"></i>
                                                    <span id="camera-status-hint">Checking...</span>
                                                </small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="panel panel-info">
                                            <div class="panel-body text-center" style="padding: 30px 15px;">
                                                <i class="fas fa-keyboard"
                                                    style="font-size: 48px; margin-bottom: 15px;"></i>
                                                <h4>Input Manual</h4>
                                                <p class="text-muted">Ketik kode asset secara manual</p>
                                                <button class="btn btn-info btn-lg" onclick="showManualInput()">
                                                    <i class="fas fa-keyboard"></i> Input Kode
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Manual Input Form -->
                            <div id="manual-input-form" style="display: none; margin-bottom: 20px;">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <i class="fas fa-keyboard"></i> Input Kode Asset Manual
                                        </h4>
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group">
                                            <label>Masukkan Kode Asset / Asset Tag:</label>
                                            <div class="input-group input-group-lg">
                                                <input type="text" id="manual-asset-tag" class="form-control"
                                                    placeholder="Contoh: A001, LAPTOP-001, dll" autofocus>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-info" type="button"
                                                        onclick="searchManualAsset()">
                                                        <i class="fas fa-search"></i> Cari
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <button class="btn btn-default" onclick="hideManualInput()">
                                            <i class="fas fa-arrow-left"></i> Kembali
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Alert Messages -->
                            <div class="text-center">
                                <div class="alert alert-info" id="camera-permission-info" style="display: none;"></div>

                                <!-- QR Reader Area -->
                                <div id="qr-reader" style="width: 100%; max-width: 600px; margin: 0 auto; display: none;">
                                </div>

                                <!-- Results -->
                                <div id="qr-reader-results" class="alert" style="display: none; margin-top: 20px;"></div>

                                <!-- Asset Link Button -->
                                <div id="asset-link-container" style="display: none; margin-top: 20px;">
                                    <a href="#" id="asset-detail-link" class="btn btn-primary btn-lg">
                                        <x-icon type="assets" /> {{ trans('general.show_detail') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('moar_styles')
    <style>
        /* Make QR scanner more compact and centered */
        #qr-reader {
            border-radius: 8px;
            overflow: hidden;
        }

        #qr-reader video {
            border-radius: 8px;
            max-height: 400px !important;
            object-fit: cover;
        }

        #qr-reader__scan_region {
            max-width: 100% !important;
        }

        #qr-reader__dashboard_section {
            padding: 10px !important;
        }

        #qr-reader__dashboard_section_csr button {
            margin: 5px !important;
        }
    </style>
@stop

@section('moar_scripts')
    <!-- Load html5-qrcode from local file instead of CDN -->
    <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
    <script>
        let html5QrcodeScanner = null;
        let libraryLoaded = false;

        // Check if library loaded successfully
        window.addEventListener('load', function() {
            if (typeof Html5QrcodeScanner !== 'undefined') {
                libraryLoaded = true;
                console.log('Html5QrcodeScanner library loaded successfully');
            } else {
                console.error('Html5QrcodeScanner library failed to load');
            }
        });

        function processQRCode(decodedText) {
            // Tampilkan hasil
            const resultsDiv = document.getElementById("qr-reader-results");
            resultsDiv.style.display = "block";
            resultsDiv.className = "alert alert-success";
            resultsDiv.innerHTML = `<strong>{{ trans('general.success') }}!</strong><br>QR Code: ${decodedText}`;

            // Cari asset berdasarkan tag
            fetch(`{{ url('/') }}/hardware/bytag/${encodeURIComponent(decodedText)}`)
                .then(response => {
                    if (response.ok) {
                        return response.url;
                    } else {
                        throw new Error('Asset not found');
                    }
                })
                .then(url => {
                    // Tampilkan tombol show detail
                    const linkContainer = document.getElementById("asset-link-container");
                    const assetLink = document.getElementById("asset-detail-link");
                    assetLink.href = url;
                    linkContainer.style.display = "block";

                    resultsDiv.innerHTML += `<br><br>{{ trans('general.asset_found') }}`;
                })
                .catch(error => {
                    resultsDiv.className = "alert alert-danger";
                    resultsDiv.innerHTML =
                        `<strong>{{ trans('general.error') }}!</strong><br>{{ trans('general.asset_not_found') }}`;
                });
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log('QR Code detected:', decodedText);
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(err => console.log('Clear error:', err));
            }
            processQRCode(decodedText);
        }

        function onScanFailure(error) {
            // Ignore scan failures, keep scanning
        }

        async function startCameraScanner() {
            const infoDiv = document.getElementById('camera-permission-info');
            const qrReaderDiv = document.getElementById('qr-reader');
            const mainOptions = document.getElementById('main-options');

            // Check if library is loaded
            if (typeof Html5QrcodeScanner === 'undefined') {
                console.error('Html5QrcodeScanner library not loaded');
                qrReaderDiv.style.display = 'none';
                mainOptions.style.display = 'none';
                infoDiv.className = 'alert alert-danger';
                infoDiv.style.display = 'block';
                infoDiv.innerHTML = `
                    <i class="fas fa-exclamation-triangle"></i> 
                    <h4><strong>Library QR Code Gagal Dimuat</strong></h4>
                    <p>Library html5-qrcode tidak berhasil dimuat dari CDN.</p>
                    <p>Kemungkinan: Koneksi internet lambat atau CDN blocked.</p>
                    <hr>
                    <div style="background: #d9edf7; padding: 15px; border-radius: 5px;">
                        <strong><i class="fas fa-lightbulb"></i> Solusi:</strong><br>
                        1. Refresh halaman ini (F5)<br>
                        2. Atau gunakan <strong>Upload Gambar</strong> untuk scan QR code
                    </div>
                    <button class="btn btn-primary" onclick="location.reload()">
                        <i class="fas fa-sync"></i> Refresh Halaman
                    </button>
                    <button class="btn btn-default" onclick="resetToMainOptions()">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                `;
                return;
            }

            // Debug info
            console.log('=== CAMERA SCANNER DEBUG ===');
            console.log('Protocol:', window.location.protocol);
            console.log('Hostname:', window.location.hostname);
            console.log('Full URL:', window.location.href);
            console.log('Is Secure Context:', window.isSecureContext);
            console.log('Navigator.mediaDevices:', navigator.mediaDevices ? 'Available' : 'NOT Available');
            console.log('Html5QrcodeScanner:', typeof Html5QrcodeScanner);

            // Check if using 127.0.0.1 instead of localhost
            const currentHost = window.location.hostname;
            const isLocalIP = currentHost === '127.0.0.1';
            const isHTTP = window.location.protocol === 'http:';

            // Show warning if using 127.0.0.1 on HTTP
            if (isLocalIP && isHTTP) {
                qrReaderDiv.style.display = 'none';
                mainOptions.style.display = 'none';
                infoDiv.className = 'alert alert-warning';
                infoDiv.style.display = 'block';

                const localhostUrl = window.location.href.replace('127.0.0.1', 'localhost');
                infoDiv.innerHTML = `
                    <i class="fas fa-exclamation-triangle"></i> 
                    <h4><strong>⚠️ Kamera Tidak Bisa Digunakan di IP 127.0.0.1</strong></h4>
                    <p>Browser Chrome memblokir akses kamera pada alamat IP 127.0.0.1 untuk keamanan.</p>
                    
                    <div style="background: #fff; padding: 15px; border-radius: 5px; margin: 15px 0; text-align: left;">
                        <strong>✅ SOLUSI TERMUDAH - Ganti URL ke localhost:</strong><br><br>
                        <div style="background: #f5f5f5; padding: 10px; border-left: 4px solid #5cb85c; margin: 10px 0;">
                            <strong>Klik tombol di bawah atau copy URL ini:</strong><br>
                            <code style="font-size: 14px; color: #c7254e; background: #f9f2f4; padding: 2px 6px; border-radius: 3px;">
                                ${localhostUrl}
                            </code>
                        </div>
                        <button class="btn btn-success btn-lg" onclick="window.location.href='${localhostUrl}'">
                            <i class="fas fa-external-link-alt"></i> Buka dengan localhost
                        </button>
                    </div>
                    
                    <hr>
                    <button class="btn btn-primary" onclick="resetToMainOptions()">
                        <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                    </button>
                `;
                return;
            }

            // Tampilkan area scanner
            qrReaderDiv.style.display = 'block';
            mainOptions.style.display = 'none';
            infoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Meminta izin kamera...';
            infoDiv.className = 'alert alert-info';
            infoDiv.style.display = 'block';

            try {
                // Check if mediaDevices is available
                if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                    console.error('MediaDevices API not available');
                    throw new Error('MediaDevices API not supported');
                }

                // Check camera permission status first (if supported)
                if (navigator.permissions && navigator.permissions.query) {
                    try {
                        const permissionStatus = await navigator.permissions.query({
                            name: 'camera'
                        });
                        console.log('Camera permission status:', permissionStatus.state);

                        if (permissionStatus.state === 'denied') {
                            throw {
                                name: 'PermissionDeniedError',
                                message: 'Camera permission was previously denied'
                            };
                        }
                    } catch (permErr) {
                        console.warn('Permission query not supported:', permErr);
                    }
                }

                // Initialize html5-qrcode scanner
                console.log('Initializing Html5QrcodeScanner...');
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: {
                            width: 200,
                            height: 200
                        },
                        aspectRatio: 1.0,
                        showTorchButtonIfSupported: true,
                        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
                        videoConstraints: {
                            facingMode: "environment",
                            width: {
                                ideal: 640
                            },
                            height: {
                                ideal: 480
                            }
                        }
                    },
                    false
                );

                console.log('Rendering scanner...');
                await html5QrcodeScanner.render(onScanSuccess, onScanFailure);

                console.log('Scanner initialized successfully');
                infoDiv.style.display = 'none';

            } catch (err) {
                console.error('Camera Error:', err);
                qrReaderDiv.style.display = 'none';
                infoDiv.className = 'alert alert-danger';

                let errorHTML = '';

                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    const isHTTPS = window.location.protocol === 'https:';

                    if (isHTTPS) {
                        errorHTML = `
                            <i class="fas fa-exclamation-triangle"></i> 
                            <h4><strong>⚠️ Akses Kamera Ditolak</strong></h4>
                            <p>Browser telah memblokir akses kamera untuk situs ini.</p>
                            
                            <div style="background: #fff; padding: 15px; border-radius: 5px; margin: 15px 0; text-align: left;">
                                <strong>📱 Cara Mengizinkan Kamera:</strong><br><br>
                                
                                <strong>1️⃣ Klik icon gembok 🔒 di address bar (kiri URL)</strong><br>
                                <strong>2️⃣ Pilih "Site settings" atau "Permissions"</strong><br>
                                <strong>3️⃣ Cari "Camera" → Ubah dari "Block" ke "Allow"</strong><br>
                                <strong>4️⃣ Refresh halaman ini (F5)</strong><br><br>
                                
                                <div style="background: #d9edf7; border-left: 4px solid #31708f; padding: 10px; margin-top: 10px;">
                                    <strong>💡 Atau coba:</strong><br>
                                    • Buka Chrome Settings → Privacy and Security → Site Settings → Camera<br>
                                    • Pastikan <code>${window.location.origin}</code> ada di "Allowed" list
                                </div>
                            </div>
                        `;
                    } else {
                        errorHTML = `
                            <i class="fas fa-exclamation-triangle"></i> 
                            <h4><strong>Akses Kamera Ditolak</strong></h4>
                            <p>Browser memblokir akses kamera karena situs tidak secure (HTTP).</p>
                            
                            <div style="background: #fff; padding: 15px; border-radius: 5px; margin: 15px 0; text-align: left;">
                                <strong>✅ Solusi: Gunakan localhost atau HTTPS</strong><br>
                                Ganti URL dari <code>http://127.0.0.1:8000</code> ke <code>http://localhost:8000</code>
                            </div>
                        `;
                    }
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    errorHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <h4><strong>Kamera Tidak Ditemukan</strong></h4>
                        <p>Tidak ada kamera yang terdeteksi di perangkat Anda.</p>
                    `;
                } else if (err.name === 'NotSupportedError' || err.message === 'MediaDevices API not supported') {
                    errorHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <h4><strong>Browser Tidak Support</strong></h4>
                        <p>Browser Anda tidak mendukung akses kamera.</p>
                    `;
                } else {
                    errorHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <h4><strong>Error: ${err.name || 'Unknown'}</strong></h4>
                        <p>${err.message || 'Gagal mengakses kamera.'}</p>
                    `;
                }

                errorHTML += `
                    <hr>
                    <div style="background: #d9edf7; padding: 15px; border-radius: 5px; margin-top: 15px;">
                        <strong><i class="fas fa-lightbulb"></i> Alternatif: Gunakan Upload Gambar</strong><br>
                        Anda bisa foto QR code dengan HP, lalu upload gambarnya di sini.
                    </div>
                    <button class="btn btn-primary btn-lg" onclick="resetToMainOptions()" style="margin-top: 15px;">
                        <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                    </button>
                `;

                infoDiv.innerHTML = errorHTML;
            }
        }

        function scanFromFile(input) {
            const file = input.files[0];
            if (!file) return;

            // Check if library is loaded
            if (typeof Html5Qrcode === 'undefined') {
                alert('Library QR Code belum dimuat. Silakan refresh halaman (F5) dan coba lagi.');
                input.value = '';
                return;
            }

            // Hide main options
            document.getElementById('main-options').style.display = 'none';

            const infoDiv = document.getElementById('camera-permission-info');
            infoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses gambar...';
            infoDiv.className = 'alert alert-info';
            infoDiv.style.display = 'block';

            const html5QrCode = new Html5Qrcode("qr-reader");

            html5QrCode.scanFile(file, true)
                .then(decodedText => {
                    console.log('QR Code from file:', decodedText);
                    infoDiv.style.display = 'none';
                    processQRCode(decodedText);
                })
                .catch(err => {
                    console.error('File scan error:', err);
                    infoDiv.className = 'alert alert-danger';
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Gagal Membaca QR Code</strong><br>
                        ${err || 'Pastikan gambar mengandung QR code yang jelas dan tidak blur.'}<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    `;
                });

            // Reset input untuk bisa upload file yang sama lagi
            input.value = '';
        }

        function showManualInput() {
            document.getElementById('main-options').style.display = 'none';
            document.getElementById('manual-input-form').style.display = 'block';
            document.getElementById('manual-asset-tag').focus();
        }

        function hideManualInput() {
            document.getElementById('manual-input-form').style.display = 'none';
            document.getElementById('main-options').style.display = 'block';
        }

        function searchManualAsset() {
            const assetTag = document.getElementById('manual-asset-tag').value.trim();

            if (!assetTag) {
                alert('Silakan masukkan kode asset terlebih dahulu!');
                return;
            }

            const infoDiv = document.getElementById('camera-permission-info');
            infoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mencari asset...';
            infoDiv.className = 'alert alert-info';
            infoDiv.style.display = 'block';

            // Hide manual input form
            document.getElementById('manual-input-form').style.display = 'none';

            // Process like QR code
            processQRCode(assetTag);
        }

        function resetToMainOptions() {
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(err => console.log('Clear error:', err));
                html5QrcodeScanner = null;
            }

            document.getElementById('main-options').style.display = 'block';
            document.getElementById('manual-input-form').style.display = 'none';
            document.getElementById('qr-reader').style.display = 'none';
            document.getElementById('camera-permission-info').style.display = 'none';
            document.getElementById('qr-reader-results').style.display = 'none';
            document.getElementById('asset-link-container').style.display = 'none';
        }

        // Check camera status on page load
        function checkCameraStatus() {
            const hintElement = document.getElementById('camera-status-hint');
            const currentHost = window.location.hostname;
            const isHTTP = window.location.protocol === 'http:';
            const isLocalIP = currentHost === '127.0.0.1';
            const isLocalhost = currentHost === 'localhost';
            const isHTTPS = window.location.protocol === 'https:';

            if (isHTTPS) {
                hintElement.innerHTML = '<span style="color: #5cb85c;">✓ HTTPS - Kamera Support</span>';
            } else if (isLocalhost) {
                hintElement.innerHTML = '<span style="color: #5cb85c;">✓ localhost - Kamera Support</span>';
            } else if (isLocalIP) {
                hintElement.innerHTML = '<span style="color: #f0ad4e;">⚠ Gunakan localhost untuk kamera</span>';
            } else {
                hintElement.innerHTML = '<span style="color: #d9534f;">✗ Perlu HTTPS untuk kamera</span>';
            }
        }

        // Allow Enter key on manual input
        document.addEventListener('DOMContentLoaded', function() {
            const manualInput = document.getElementById('manual-asset-tag');
            if (manualInput) {
                manualInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        searchManualAsset();
                    }
                });
            }

            // Check camera status
            checkCameraStatus();
        });
    </script>
@stop
