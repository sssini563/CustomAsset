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
                        <div class="col-md-12 text-center">
                            <div id="qr-reader" style="width: 100%; max-width: 600px; margin: 0 auto;"></div>
                            <div id="qr-reader-results" class="alert" style="display: none; margin-top: 20px;"></div>
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
@stop

@section('moar_scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Hentikan scanner
            html5QrcodeScanner.clear();

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

        function onScanFailure(error) {
            // Handle scan failure, usually better to ignore and keep scanning
            console.warn(`QR Code scan error: ${error}`);
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", {
                fps: 10,
                qrbox: {
                    width: 250,
                    height: 250
                },
                aspectRatio: 1.0
            },
            /* verbose= */
            false
        );
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
@stop
