@php($link = route('public.documents.approval.show', [$sig->public_token]))
@php($expired = $sig->public_token_expires_at && now()->greaterThan($sig->public_token_expires_at))
<div class="btn-group" role="group">
  @can('update', $document)
    @if($sig->status==='pending')
      <button class="btn btn-xs btn-default" data-action="copy-link" data-role="{{ $sig->role }}" data-id="{{ $document->id }}" data-link="{{ $link }}" title="Copy link"><i class="fa fa-link"></i></button>
      <button class="btn btn-xs btn-primary" data-action="send-link" data-role="{{ $sig->role }}" data-id="{{ $document->id }}" title="Send link to email"><i class="fa fa-envelope"></i></button>
      <button class="btn btn-xs btn-info" data-action="regen-token" data-role="{{ $sig->role }}" data-id="{{ $document->id }}" title="{{ ($expired ? 'Enable token' : 'Regenerate token') }}">
        <i class="fa {{ $expired ? 'fa-play' : 'fa-refresh' }}"></i>
      </button>
      <button class="btn btn-xs btn-default" data-action="disable-token" data-role="{{ $sig->role }}" data-id="{{ $document->id }}" title="Disable token"><i class="fa fa-ban"></i></button>
    @elseif(in_array($sig->status,['signed','rejected']))
      <button class="btn btn-xs btn-warning" data-action="cancel-signature" data-role="{{ $sig->role }}" data-id="{{ $document->id }}" title="Cancel approval"><i class="fa fa-undo"></i></button>
    @endif
  @endcan
</div>
@if($sig->public_token_expires_at)
  <div><small class="{{ $expired ? 'text-danger' : 'text-muted' }}">token {{ $expired ? 'expired' : 'exp' }}: {{ $sig->public_token_expires_at->format('Y-m-d H:i') }}</small></div>
@endif
@if($sig->last_used_at)
  <div><small class="text-muted">last used: {{ $sig->last_used_at->format('Y-m-d H:i') }}</small></div>
@endif
