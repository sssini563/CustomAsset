<?php

return [
    // Masa berlaku default (hari) untuk public token signature.
    // Bisa diubah via .env: DOCUMENT_PUBLIC_TOKEN_DAYS=14
    'public_token_days' => env('DOCUMENT_PUBLIC_TOKEN_DAYS', 14),

    // Gunakan Node+Puppeteer (node/pdf-render.js) untuk generate PDF dari HTML.
    // Default dimatikan untuk menghindari timeout saat pertama kali Puppeteer mengunduh Chromium.
    // Aktifkan via .env jika lingkungan sudah siap: DOCUMENT_USE_NODE_PDF=true
    'use_node_pdf' => env('DOCUMENT_USE_NODE_PDF', false),
];
