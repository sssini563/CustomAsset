@php($status = strtolower($signature && isset($signature->status) ? $signature->status : ''))

@if ($status === 'signed')
    <img class="qr stamp" src="{{ asset('img/approved.png') }}" alt="Approved" />
@elseif($status === 'rejected')
    <img class="qr stamp" src="{{ asset('img/rejected.png') }}" alt="Rejected" />
@else
    <div></div>
    {{-- <div class="qr stamp pending"
        style="border:1px dashed #c0c0c0;color:#999;display:flex;align-items:center;justify-content:center;font-size:8pt;">
        Pending</div> --}}
@endif
