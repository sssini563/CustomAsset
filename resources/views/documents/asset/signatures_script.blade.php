<script>
(function(){
  var USERS_MAP = (function(){ try { return JSON.parse(document.getElementById('users-data').textContent); } catch(e){ return {}; } })();
  function updateRowDisplayBySigId(sigId, userId){
    var nameEl = document.querySelector('.sig-name[data-sig-id="'+sigId+'"]');
    var emailEl = document.querySelector('.sig-email[data-sig-id="'+sigId+'"]');
    var empEl = document.querySelector('.sig-employee[data-sig-id="'+sigId+'"]');
    var user = USERS_MAP[userId] || {};
    if(nameEl) nameEl.textContent = user.name || '';
    if(emailEl) emailEl.textContent = user.email || '';
    if(empEl) empEl.textContent = user.employee_num || '';
    var btn = document.querySelector('.btn-edit-person[data-sig-id="'+sigId+'"][data-user-id]');
    if(btn){
      btn.setAttribute('data-user-id', userId || '');
      btn.setAttribute('data-user-name', user.name || '');
      btn.setAttribute('data-email', user.email || '');
      btn.setAttribute('data-employee-num', user.employee_num || '');
    }
  }
  function getManagerIdOf(userId){ var u = USERS_MAP[userId]; return u && u.manager_id ? String(u.manager_id) : ''; }
  function getUserName(userId){ var u = USERS_MAP[userId]; return u && u.name ? u.name : ''; }
  var sigSelects = Array.prototype.slice.call(document.querySelectorAll('select.sig-select'));
  var selectsByRole = sigSelects.reduce(function(acc, el){ acc[el.getAttribute('data-role')] = el; return acc; }, {});
  sigSelects.forEach(function(sel){ sel.addEventListener('change', function(){ var sigId = this.getAttribute('data-sig-id'); updateRowDisplayBySigId(sigId, this.value || ''); }); });
  function setSelectValue(sel, val){ if(!sel) return; var strVal = (val==null? '': String(val)); if(!strVal) return; var found = false; for (var i=0;i<sel.options.length;i++){ if (String(sel.options[i].value)===strVal) { found=true; break; } } if(found){ sel.value = strVal; var evt = document.createEvent('HTMLEvents'); evt.initEvent('change', true, false); sel.dispatchEvent(evt); } }
  var atasanInput = document.querySelector('input[name="atasan_penerima_name"]');
  if (selectsByRole['creator'] && selectsByRole['creator_manager']){
    selectsByRole['creator'].addEventListener('change', function(){ var creatorId = this.value; var mgrId = getManagerIdOf(creatorId); if (mgrId){ setSelectValue(selectsByRole['creator_manager'], mgrId); } });
  }
  if (selectsByRole['user'] && selectsByRole['user_manager']){
    selectsByRole['user'].addEventListener('change', function(){ var userId = this.value; var mgrId = getManagerIdOf(userId); if (mgrId){ setSelectValue(selectsByRole['user_manager'], mgrId); } if (atasanInput){ atasanInput.value = getUserName(mgrId) || atasanInput.value; } });
  }
  if (selectsByRole['user_manager']){
    selectsByRole['user_manager'].addEventListener('change', function(){ if (atasanInput){ atasanInput.value = getUserName(this.value) || atasanInput.value; } });
  }
})();
</script>
