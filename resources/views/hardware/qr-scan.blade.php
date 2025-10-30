@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.scan_qr') }}
    @parent
@stop

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
                                                    <i class="fas fa-exclamation-triangle"></i> Memerlukan HTTPS atau
                                                    setting khusus
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
                                <div id="qr-reader"
                                    style="width: 100%; max-width: 800px; min-height: 500px; margin: 0 auto; display: none;">
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

@section('moar_scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let html5QrcodeScanner = null;

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
            // Hentikan scanner
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear();
            }
            processQRCode(decodedText);
        }

        function onScanFailure(error) {
            // Handle scan failure, usually better to ignore and keep scanning
            console.warn(`QR Code scan error: ${error}`);
        }

        async function startCameraScanner() {
            const infoDiv = document.getElementById('camera-permission-info');
            const qrReaderDiv = document.getElementById('qr-reader');
            const mainOptions = document.getElementById('main-options');

            // Tampilkan area scanner
            qrReaderDiv.style.display = 'block';
            mainOptions.style.display = 'none';
            infoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Meminta izin kamera...';
            infoDiv.className = 'alert alert-info';
            infoDiv.style.display = 'block';

            try {
                // Test camera access first using getUserMedia
                console.log('Requesting camera access...');
                const stream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment"
                    }
                });

                // Stop the test stream immediately
                stream.getTracks().forEach(track => track.stop());
                console.log('Camera access granted!');

                // Now initialize the scanner
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "qr-reader", {
                        fps: 10,
                        qrbox: {
                            width: 400,
                            height: 400
                        },
                        aspectRatio: 1.0,
                        showTorchButtonIfSupported: true,
                        formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
                    },
                    /* verbose= */
                    false
                );

                html5QrcodeScanner.render(onScanSuccess, onScanFailure).then(() => {
                    // Sembunyikan pesan info setelah scanner berhasil diinisialisasi
                    infoDiv.style.display = 'none';
                    console.log('Scanner initialized successfully');
                }).catch(err => {
                    throw err;
                });

            } catch (err) {
                // Tampilkan error jika ada masalah
                console.error('Camera Error:', err);
                qrReaderDiv.style.display = 'none';
                infoDiv.className = 'alert alert-danger';

                if (err.name === 'NotAllowedError' || err.name === 'PermissionDeniedError') {
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Akses Kamera Ditolak</strong><br>
                        Browser tidak mengizinkan akses kamera pada situs HTTP (tidak secure).<br><br>
                        <strong>Solusi untuk Enable Kamera:</strong><br>
                        1. Buka tab baru, ketik: <code>chrome://flags/#unsafely-treat-insecure-origin-as-secure</code><br>
                        2. Masukkan URL: <code>http://127.0.0.1:8000</code><br>
                        3. Klik "Enable" dan restart Chrome<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                        </button>
                    `;
                } else if (err.name === 'NotFoundError' || err.name === 'DevicesNotFoundError') {
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Kamera Tidak Ditemukan</strong><br>
                        Tidak ada kamera yang terdeteksi di perangkat Anda.<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                        </button>
                    `;
                } else if (err.name === 'NotSupportedError') {
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Browser Tidak Support</strong><br>
                        Browser Anda tidak mendukung akses kamera atau situs ini tidak secure (HTTPS).<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                        </button>
                    `;
                } else {
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Error: ${err.name || 'Unknown'}</strong><br>
                        ${err.message || 'Gagal mengakses kamera.'}<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali & Gunakan Upload/Manual
                        </button>
                    `;
                }
            }
        }

        function scanFromFile(input) {
            const file = input.files[0];
            if (!file) return;

            // Hide main options
            document.getElementById('main-options').style.display = 'none';

            const infoDiv = document.getElementById('camera-permission-info');
            infoDiv.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses gambar...';
            infoDiv.className = 'alert alert-info';
            infoDiv.style.display = 'block';

            const html5QrCode = new Html5Qrcode("qr-reader");

            html5QrCode.scanFile(file, true)
                .then(decodedText => {
                    infoDiv.style.display = 'none';
                    processQRCode(decodedText);
                })
                .catch(err => {
                    infoDiv.className = 'alert alert-danger';
                    infoDiv.innerHTML = `
                        <i class="fas fa-exclamation-triangle"></i> 
                        <strong>Gagal Membaca QR Code</strong><br>
                        ${err || 'Pastikan gambar mengandung QR code yang jelas dan tidak blur.'}<br><br>
                        <button class="btn btn-primary" onclick="resetToMainOptions()">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </button>
                    `;
                    console.error('File scan error:', err);
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
            document.getElementById('main-options').style.display = 'block';
            document.getElementById('manual-input-form').style.display = 'none';
            document.getElementById('qr-reader').style.display = 'none';
            document.getElementById('camera-permission-info').style.display = 'none';
            document.getElementById('qr-reader-results').style.display = 'none';
            document.getElementById('asset-link-container').style.display = 'none';

            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(err => console.log('Already cleared'));
                html5QrcodeScanner = null;
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
        });
    </script>
@stop
