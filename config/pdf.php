<?php

return [
    // Prefer headless Chrome via spatie/browsershot when available to render PDFs using @media print CSS.
    // When false or not installed, the app will fall back to TCPDF.
    'prefer_browsershot' => env('PDF_PREFER_BROWSERSHOT', true),
];