@extends('layouts/default')
@section('title') Sign Document {{ $document->document_number }} - {{ $signature->role }} @stop
@section('content')
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Sign {{ $document->document_number }} as {{ ucfirst(str_replace('_',' ',$signature->role)) }}</h3>
  </div>
  <div class="box-body">
    <p>Silakan review dokumen dan lakukan tanda tangan dari halaman ini.</p>
    <div class="btn-group">
      <form method="post" action="{{ url('documents/'.$document->id.'/sign/'.$signature->role) }}" style="display:inline">@csrf<button class="btn btn-success">Approve</button></form>
      <form method="post" action="{{ url('documents/'.$document->id.'/reject/'.$signature->role) }}" style="display:inline">@csrf<button class="btn btn-danger">Reject</button></form>
      <a href="{{ route('documents.print',$document->id) }}" target="_blank" class="btn btn-default">Preview</a>
    </div>
  </div>
</div>
@endsection
