<?php
namespace App\Policies;

use App\Models\{User, Document};

class DocumentPolicy
{
    public function viewAny(User $user): bool { return $user->can('view', \App\Models\Asset::class) || $user->isSuperUser(); }
    public function view(User $user, Document $document): bool { return $this->viewAny($user); }
    public function update(User $user, Document $document): bool {
        if ($document->overall_status === 'complete') return false; // locked
        return $user->isSuperUser() || $user->id === $document->created_by;
    }
    public function delete(User $user, Document $document): bool { return $user->isSuperUser() && $document->overall_status === 'pending'; }
    public function cancelApproval(User $user, Document $document): bool { return $user->isSuperUser() && $document->overall_status === 'pending'; }

    public function sign(User $user, Document $document, string $role): bool
    {
    // Deny only if document already completed (locked)
    if ($document->overall_status === 'complete') return false;
        $sig = $document->getSignature($role);
        if (!$sig || $sig->status!=='pending') return false;
        // Enforce ordering: only allow signing if all previous signatures are signed (sequential workflow)
        $document->loadMissing('signatures');
        $legacy = ['it_manager','atasan_penerima'];
        $previousPending = $document->signatures
            ->where('ordering','<',$sig->ordering)
            ->reject(fn($s)=> in_array($s->role,$legacy))
            ->filter(fn($s)=> !is_null($s->user_id))
            ->filter(fn($s)=> $s->status!=='signed');
        if ($previousPending->count()>0) return false;

        return match($role) {
            'creator' => $sig->user_id === $user->id,
            'creator_manager' => ($sig->user_id && $sig->user_id === $user->id) || $user->hasAccess('documents.approve.it'),
            'user' => $sig->user_id === $user->id,
            'user_manager' => ($sig->user_id && $sig->user_id === $user->id) || $user->hasAccess('documents.approve.superior'),
            'hr' => ($sig->user_id && $sig->user_id === $user->id) || $user->hasAccess('documents.approve.hr'),
            // Backward compatibility (legacy roles if any dangling rows exist)
            'it_manager' => ($sig->user_id && $sig->user_id === $user->id) || $user->hasAccess('documents.approve.it'),
            'atasan_penerima' => ($sig->user_id && $sig->user_id === $user->id) || $user->hasAccess('documents.approve.superior'),
            default => false
        };
    }

    public function reject(User $user, Document $document, string $role): bool
    {
        return $this->sign($user, $document, $role); // same rules as sign
    }
}
