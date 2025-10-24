<?php

namespace App\Observers;

use App\Models\Actionlog;
use App\Models\DocumentSignature;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Listen to the User updating event. This fires automatically every time an existing asset is saved.
     *
     * @param  User  $user
     * @return void
     */
    public function updating(User $user)
    {

        // ONLY allow these fields to be stored
        $allowed_fields = [
            'email',
            'activated',
            'first_name',
            'last_name',
            'website',
            'country',
            'gravatar',
            'location_id',
            'phone',
            'jobtitle',
            'manager_id',
            'employee_num',
            'username',
            'notes',
            'company_id',
            'ldap_import',
            'locale',
            'two_factor_enrolled',
            'two_factor_optin',
            'department_id',
            'address',
            'address2',
            'city',
            'state',
            'zip',
            'remote',
            'start_date',
            'end_date',
            'autoassign_licenses',
            'vip',
            'password'
        ];
        
        $changed = [];

        foreach ($user->getRawOriginal() as $key => $value) {

            // Make sure the info is in the allow fields array
            if (in_array($key, $allowed_fields)) {

                // Check and see if the value changed
                if ($user->getRawOriginal()[$key] != $user->getAttributes()[$key]) {

                    $changed[$key]['old'] = $user->getRawOriginal()[$key];
                    $changed[$key]['new'] = $user->getAttributes()[$key];

                    // Do not store the hashed password in changes
                    if ($key == 'password') {
                        $changed['password']['old'] = '*************';
                        $changed['password']['new'] = '*************';
                    }

                }
            }

        }

        if (count($changed) > 0) {
            $logAction = new Actionlog();
            $logAction->item_type = User::class;
            $logAction->item_id = $user->id;
            $logAction->target_type = User::class; // can we instead say $logAction->item = $asset ?
            $logAction->target_id = $user->id;
            $logAction->created_at = date('Y-m-d H:i:s');
            $logAction->created_by = auth()->id();
            $logAction->log_meta = json_encode($changed);
            $logAction->logaction('update');
        }


    }

    /**
     * Listen to the User updated event to sync document signatures
     *
     * @param  User $user
     * @return void
     */
    public function updated(User $user)
    {
        // Sync signatures when manager changes
        if ($user->wasChanged('manager_id')) {
            $newManagerId = $user->manager_id;

            // Update user_manager signatures for documents where this user is the 'user' (penerima)
            $userSignatures = DocumentSignature::where('role', 'user')
                ->where('user_id', $user->id)
                ->get();

            foreach ($userSignatures as $userSig) {
                DocumentSignature::where('document_id', $userSig->document_id)
                    ->where('role', 'user_manager')
                    ->update(['user_id' => $newManagerId]);
            }

            // Update creator_manager signatures for documents where this user is the 'creator'
            $creatorSignatures = DocumentSignature::where('role', 'creator')
                ->where('user_id', $user->id)
                ->get();

            foreach ($creatorSignatures as $creatorSig) {
                DocumentSignature::where('document_id', $creatorSig->document_id)
                    ->where('role', 'creator_manager')
                    ->update(['user_id' => $newManagerId]);
            }
        }
    }

    /**
     * Listen to the User created event, and increment
     * the next_auto_tag_base value in the settings table when i
     * a new asset is created.
     *
     * @param  User $user
     * @return void
     */
    public function created(User $user)
    {
        $logAction = new Actionlog();
        $logAction->item_type = User::class; // can we instead say $logAction->item = $asset ?
        $logAction->item_id = $user->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('create');
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User $user
     * @return void
     */
    public function deleting(User $user)
    {
        $logAction = new Actionlog();
        $logAction->item_type = User::class;
        $logAction->item_id = $user->id;
        $logAction->target_type = User::class; // can we instead say $logAction->item = $asset ?
        $logAction->target_id = $user->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('delete');
    }

    /**
     * Listen to the User deleting event.
     *
     * @param  User $user
     * @return void
     */
    public function restoring(User $user)
    {
        $logAction = new Actionlog();
        $logAction->item_type = User::class;
        $logAction->item_id = $user->id;
        $logAction->target_type = User::class; // can we instead say $logAction->item = $asset ?
        $logAction->target_id = $user->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->created_by = auth()->id();
        $logAction->logaction('restore');
    }


}
