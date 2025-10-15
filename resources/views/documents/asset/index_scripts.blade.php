@section('moar_scripts')
<style>
  td [class*='btn'].btn-xs.doc-action i { line-height: 1; }
  td [class*='btn'].btn-xs { padding:4px 6px; }
  td [class*='btn'].btn-xs i { font-size:13px; }
</style>
<script>
(function(){
  var BASE_URL = "{{ url('') }}";
  function hasJQuery(){ return typeof window.jQuery !== 'undefined'; }
  function initTooltips(){ try { if (hasJQuery() && typeof jQuery.fn.tooltip === 'function') { jQuery('[data-toggle="tooltip"]').tooltip(); } } catch(e) {} }
  function showModal(){
    var modal = document.getElementById('globalDocumentModal');
    if (!modal) return;
    if (hasJQuery() && typeof jQuery(modal).modal === 'function') { jQuery(modal).modal('show'); return; }
    modal.style.display = 'block'; modal.classList.add('in'); modal.setAttribute('aria-hidden','false'); document.body.classList.add('modal-open');
    var backdrop = document.createElement('div'); backdrop.className='modal-backdrop fade in'; backdrop.id='globalDocumentBackdrop'; document.body.appendChild(backdrop);
  }
  function hideModal(){
    var modal = document.getElementById('globalDocumentModal'); if (!modal) return;
    if (hasJQuery() && typeof jQuery(modal).modal === 'function') { jQuery(modal).modal('hide'); return; }
    modal.classList.remove('in'); modal.style.display='none'; modal.setAttribute('aria-hidden','true'); document.body.classList.remove('modal-open');
    var backdrop=document.getElementById('globalDocumentBackdrop'); if(backdrop&&backdrop.parentNode) backdrop.parentNode.removeChild(backdrop);
  }
  function loadModal(id,type){
    var modal = document.getElementById('globalDocumentModal'); if (modal) { var content = modal.querySelector('.modal-content'); if (content) content.innerHTML = '<div class="modal-body"><p>Loading...</p></div>'; }
    showModal();
    fetch('/documents/'+id+'/modal-'+type,{headers:{'Accept':'text/html'}})
      .then(r=>{ if(!r.ok) throw new Error(''+r.status); return r.text(); })
      .then(html=>{ var modal = document.getElementById('globalDocumentModal'); var content = modal ? modal.querySelector('.modal-content') : null; if (content) content.innerHTML = html; initTooltips(); })
      .catch(function(err){ hideModal(); alert('Gagal memuat modal ('+(err.message||'error')+')'); });
  }
  document.addEventListener('click',function(e){
    if(e.target.matches('[data-dismiss="modal"], [data-dismiss="modal"] *')){ hideModal(); return; }
    if(e.target.closest('[data-action]')){
      (async function(){
        var btn = e.target.closest('[data-action]'); var role = btn.getAttribute('data-role'); var id = btn.getAttribute('data-id'); var action = btn.getAttribute('data-action');
        try{
          if(action==='copy-link'){
            const link = btn.getAttribute('data-link');
            try{ if(navigator.clipboard && window.isSecureContext){ await navigator.clipboard.writeText(link); } else { const ta = document.createElement('textarea'); ta.value = link; ta.style.position='fixed'; ta.style.opacity='0'; document.body.appendChild(ta); ta.focus(); ta.select(); document.execCommand('copy'); document.body.removeChild(ta);} }
            catch(_e){ alert('Gagal menyalin tautan'); }
            return;
          }
          if(action==='send-link'){
            let r = await fetch('/documents/'+id+'/signature/'+role+'/send-link',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}});
            if(!r.ok) throw new Error('Failed to send'); alert('Link sent to signer email.'); return;
          }
          if(action==='cancel-signature'){
            if(!confirm('Cancel this signature (reset to pending)?')) return;
            let r = await fetch('/documents/'+id+'/signature/'+role+'/cancel',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}); if(!r.ok) throw new Error('Failed to cancel'); reloadApproval(); return;
          }
          if(action==='regen-token'){
            if(!confirm('Regenerate public token for this signer?')) return;
            let r = await fetch('/documents/'+id+'/signature/'+role+'/regenerate-token',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}); if(!r.ok) throw new Error('Failed to regenerate'); alert('Token regenerated.'); return;
          }
          if(action==='disable-token'){
            if(!confirm('Disable this public token now?')) return;
            let r = await fetch('/documents/'+id+'/signature/'+role+'/disable-token',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}); if(!r.ok) throw new Error('Failed to disable'); alert('Token disabled.'); reloadApproval(); return;
          }
        }catch(err){ alert(err.message||'Error'); }
      })();
      return;
    }
    if(e.target.closest('[data-modal]')){ var btn=e.target.closest('[data-modal]'); loadModal(btn.getAttribute('data-id'),btn.getAttribute('data-modal')); }
    if(e.target.closest('[data-delete]')){ var del=e.target.closest('[data-delete]'); if(del.disabled || del.classList.contains('disabled')) return; if(!confirm('Delete this document?')) return; var id=del.getAttribute('data-delete'); fetch('/documents/'+id,{method:'DELETE',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(r=>{ if(!r.ok) throw new Error(); return r.json(); }).then(()=>location.reload()).catch(()=> alert('Gagal menghapus dokumen.')); }
    if(e.target.closest('[data-lock]')){ var lockBtn = e.target.closest('[data-lock]'); var id = lockBtn.getAttribute('data-lock'); var orig = lockBtn.innerHTML; lockBtn.disabled = true; lockBtn.innerHTML = '<i class="fa fa-spinner fa-spin"></i>'; fetch('/documents/'+id+'/complete', {method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(async r=>{ if(!r.ok){ let m='Lock failed'; try{const j=await r.json(); if(j.message) m=j.message;}catch(_){} throw new Error(m);} return r.json(); }).then(()=>{ window.location.href = BASE_URL + '/documents/'+id+'/pdf'; }).catch(err=>{ alert(err.message||'Error'); lockBtn.disabled=false; lockBtn.innerHTML=orig; }); return; }
    if(e.target.closest('[data-complete]')){ var btn=e.target.closest('[data-complete]'); if(btn.disabled) return; if(!confirm('Mark this document as COMPLETE and lock it from further edits?')) return; var id=btn.getAttribute('data-complete'); var origHtml=btn.innerHTML; btn.disabled=true; btn.innerHTML='<i class="fa fa-spinner fa-spin"></i>'; fetch('/documents/'+id+'/complete',{method:'POST',headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}','Accept':'application/json'}}).then(async r=>{ if(!r.ok){ let msg='Failed to complete'; try{ const j=await r.json(); if(j && j.message) msg=j.message; }catch(_e){} throw new Error(msg); } return r.json(); }).then(()=> location.reload()).catch(err=>{ alert(err.message||'Error'); btn.disabled=false; btn.innerHTML=origHtml; }) }
  });
  window.reloadApproval=function(){ var modal = document.getElementById('globalDocumentModal'); if (!modal) return; var el = modal.querySelector('[data-role]') || modal.querySelector('[data-modal]') || modal; var id = el ? el.getAttribute('data-id') : null; if (id) loadModal(id,'approval'); }
  document.addEventListener('DOMContentLoaded', initTooltips);
})();
</script>
<div class="modal fade" id="globalDocumentModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" style="width: 95vw; max-width: 1400px;">
    <div class="modal-content"></div>
  </div>
</div>
@endsection
