<p>Dear {{ $signature->user_name ?? 'User' }},</p>
<p>Please review and sign the following document:</p>
<p><strong>{{ $document->document_number }}</strong></p>
<p>Role: <strong>{{ $signature->role }}</strong></p>
<p><a href="{{ $link }}">Open signature page</a></p>
<p>Thank you.</p>
