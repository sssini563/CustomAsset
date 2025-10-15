<div class="row">
  <div class="col-md-12">
    <table class="table table-condensed table-bordered">
      <thead><tr><th>Role</th><th>Current User</th><th>Email</th><th>Employee ID</th><th>Status</th><th>Assign User</th></tr></thead>
      <tbody>
      @foreach($document->signatures->sortBy('ordering') as $sig)
        @if(strtolower($document->type)!=='asset' && !in_array($sig->role,['creator','user']))
          @continue
        @endif
        @if(in_array($sig->role, ['it_manager','atasan_penerima']))
          @continue
        @endif
        @php $displayRole = $sig->role; @endphp
        @if($sig->role==='creator_manager') @php $displayRole = 'IT Manager'; @endphp @endif
        @if($sig->role==='user_manager') @php $displayRole = 'Atasan Penerima'; @endphp @endif
        @if($sig->role==='hr') @php $displayRole = 'HR'; @endphp @endif
        <tr>
          <td>{{ $displayRole }}</td>
          <td><span class="sig-cell sig-name" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->present()->fullName ?? $sig->user_name }}</span></td>
          <td><span class="sig-cell sig-email" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->email }}</span></td>
          <td><span class="sig-cell sig-employee" data-sig-id="{{ $sig->id }}">{{ optional($sig->user)->employee_num }}</span></td>
          <td>{{ $sig->status }}</td>
          <td>
            @php
              // Unlock Requestor/User: allow editing the 'user' row when status is pending.
              $allowEdit = ($sig->role==='creator' || $sig->role==='creator_manager' || $sig->status==='pending');
            @endphp
            @if($allowEdit)
              <div class="input-group input-group-sm">
                <select name="signature_users[{{ $sig->id }}]" class="form-control input-sm sig-select" data-role="{{ $sig->role }}" data-sig-id="{{ $sig->id }}">
                  <option value="">-- pilih user --</option>
                  @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ $sig->user_id==$u->id ? 'selected' : '' }}>{{ $u->present()->fullName ?? ($u->name ?? $u->username) }}</option>
                  @endforeach
                </select>
                @php $p = optional($sig->user); @endphp
                <span class="input-group-btn"><button type="button" class="btn btn-default btn-edit-person" title="Edit" data-sig-id="{{ $sig->id }}" data-user-id="{{ $p->id }}" data-user-name="{{ $p->present()->fullName ?? ($p->name ?? $p->username) }}" data-email="{{ $p->email }}" data-employee-num="{{ $p->employee_num }}"><i class="fa fa-pencil"></i></button></span>
              </div>
            @else
              <em>Locked</em>
            @endif
          </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>
