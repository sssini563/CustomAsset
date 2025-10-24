<?php
namespace App\Services;

use App\Models\{Asset, Actionlog, Document, DocumentSignature, User, Component, Accessory, Consumable, License, LicenseSeat, Location};
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Factory/service to build Document & signature records from an asset checkout.
 */
class DocumentCreator
{
    /**
     * Generate a temporary unique document_number for non-asset docs to satisfy DB uniqueness.
     */
    protected static function tempDocNumber(string $type): string
    {
        try {
            $rand = bin2hex(random_bytes(4));
        } catch (\Throwable $e) {
            $rand = uniqid();
        }
        return strtoupper($type).'-TEMP-'.$rand.'-'.time();
    }
    /**
     * Generate a temporary unique document_number for non-asset documents.
     * The displayed number for non-assets is derived via accessor and does not use this value.
     */
    protected static function tempNumber(string $type): string
    {
        return 'NA-'.strtoupper($type).'-'.date('YmdHis').'-'.substr(bin2hex(random_bytes(4)), 0, 8);
    }
    public static function fromAssetCheckout(Asset $asset, Actionlog $actionLog, User $creator, bool $createIfFlag = true): ?Document
    {
        if (!$createIfFlag) { return null; }
        Log::info('[DocumentCreator] Start creation request', [
            'asset_id' => $asset->id,
            'action_log_id' => $actionLog->id,
            'creator_id' => $creator->id,
            'assigned_to' => $asset->assigned_to,
        ]);

        return DB::transaction(function () use ($asset,$actionLog,$creator) {
            $managerId = self::findManagerId(optional($asset->assignedTo));
            $managerName = self::findManagerName(optional($asset->assignedTo));
            $assignedUser = $asset->assignedTo; // user receiving the asset
            $assignedUserFullName = $assignedUser?->present()?->fullName;
            $assignedUserUsername = $assignedUser->username ?? null;
            // Per requirement: Requestor & ID should remain blank unless explicitly provided later
            $checkoutUserName = '';

            // Resolve IT manager (fallback to creator when none found)
            $itManagerUserId = self::findItManagerUserId();
            $itManagerName = self::findItManagerName();
            if (!$itManagerUserId) {
                $itManagerUserId = $creator->id;
            }
            if (!$itManagerName) {
                $itManagerName = $creator->present()?->fullName;
            }
            $manufacturer = optional(optional($asset->model)->manufacturer)->name;
            $categoryName = optional(optional($asset->model)->category)->name;
            // Asset Number snapshot: use asset_tag (stable, visible in UI)
            $assetNumberSnapshot = $asset->asset_tag;
            Log::info('[DocumentCreator] Building document payload', [
                'asset_id' => $asset->id,
                'asset_number_snapshot' => $assetNumberSnapshot,
                'manager_id' => $managerId,
                'manager_name' => $managerName,
                'it_manager_user_id' => $itManagerUserId,
                'it_manager_name' => $itManagerName,
            ]);
            // No longer storing per-document metadata; rely on settings at render time
            $sp = Setting::getSettings();
            // Generate No Tanda Terima and derive 3-digit document_no
            $generated = DocumentNumberGenerator::generateForAsset($asset);
            $generatedSuffix = preg_match('/(\d{3})$/', $generated, $m) ? $m[1] : null;
            $document = Document::create([
                    'type' => 'asset',
                    'asset_id' => $asset->id,
                    'asset_log_id' => $actionLog->id,
                    // No Tanda Terima per requirement: FAC/HO + 3 digit
                    'document_number' => $generated,
                    // Separate Document Number (initially same as No Tanda Terima; can be edited later)
                    'document_no' => $generatedSuffix,
                    // Document Date = tanggal dibuat
                    'document_date' => now()->toDateString(),
                    // Header info
                    'organization_structure' => optional(optional($asset->assignedTo)->department)->name,
                    'position' => optional($asset->assignedTo)->jobtitle,
                    'location' => optional($asset->location)->name,
                    // Requestor & ID
                    // Keep Requestor blank unless explicitly set later
                    'requestor_user_id' => null,
                    'checkout_user_name' => $checkoutUserName,
                    // Recipient data
                    'nama_penerima' => $assignedUserFullName,
                    'atasan_penerima_name' => $managerName,
                    // Penerima extras
                    'asset_number' => $assetNumberSnapshot,
                    'gr_number' => null,
                    // Type Asset from category
                    'type_device' => optional(optional($asset->model)->category)->name,
                    // Hardware
                    'device_name' => $asset->asset_tag, // per requirement: device name from asset tag
                    'serial_number_device' => $asset->serial,
                    'serial_number_adaptor' => null,
                    'foto_device' => null,
                    // Software
                    'windows' => $asset->windows ?? null,
                    'office' => $asset->office ?? null,
                    'antivirus' => $asset->antivirus ?? null,
                    'compress_tools' => $asset->compress_tools ?? null,
                    'reader_tool' => $asset->reader_tool ?? null,
                    'browser' => $asset->browser ?? null,
                    'other_application_1' => $asset->other_application_1 ?? null,
                    'other_application_2' => $asset->other_application_2 ?? null,
                    'other_application_3' => $asset->other_application_3 ?? null,
                    'other_application_4' => $asset->other_application_4 ?? null,
                    // Documents/Notes (default empty)
                    'dokumen_pengembalian_asset' => null,
                    'dokumen_surat_pernyataan' => null,
                    'catatan' => null,
                    // Status
                    'overall_status' => 'pending',
                    'created_by' => $creator->id,
            ]);

            // Build signatures (snapshot user names now for audit)
            // Additional manager signatures (creator_manager & user_manager) start empty; they will be auto-synced on edit.
            // Simplified roles: original it_manager & atasan_penerima rows removed; use *_manager shadow roles only.
            $signatures = [
                ['role'=>'creator','user_id'=>$creator->id,'user_name'=>$creator->present()->fullName,'ordering'=>1],
                ['role'=>'creator_manager','user_id'=>$itManagerUserId,'user_name'=>$itManagerName,'ordering'=>2],
                ['role'=>'user','user_id'=>$asset->assigned_to,'user_name'=>$assignedUserFullName,'ordering'=>3],
                ['role'=>'user_manager','user_id'=>$managerId,'user_name'=>$managerName,'ordering'=>4],
                // HR approval (assignment can be set later in Edit or Approval modal)
                ['role'=>'hr','user_id'=>null,'user_name'=>null,'ordering'=>5],
            ];
            foreach ($signatures as $sig) {
                DocumentSignature::create(array_merge($sig,[ 'document_id'=>$document->id ]));
            }
            Log::info('[DocumentCreator] Document created', [
                'document_id' => $document->id,
                'document_number' => $document->document_number,
                'signatures_created' => count($signatures),
            ]);
            return $document;
        });
    }

    protected static function findItManagerUserId(): ?int
    {
        // Fallback: first active user with show_in_list=1 (no superuser column in this schema)
        $user = User::where('show_in_list',1)->orderBy('id')->first();
        return $user?->id;
    }
    protected static function findItManagerName(): ?string
    {
        $user = User::where('show_in_list',1)->orderBy('id')->first();
        return $user?->present()?->fullName;
    }
    protected static function findManagerId($user): ?int
    {
        if (!$user) return null;
        return $user->manager_id ?? null; // assumes column exists; if not, stays null
    }
    protected static function findManagerName($user): ?string
    {
        if (!$user || !($user->manager_id ?? null)) return null;
        $manager = User::find($user->manager_id);
        return $manager?->present()->fullName;
    }
    /**
     * Create a document from a component checkout to an asset.
     */
    public static function fromComponentCheckout(Component $component, Asset $asset, User $creator, ?string $note = null, bool $create = true): ?Document
    {
        if (!$create) return null;
        return DB::transaction(function () use ($component,$asset,$creator,$note) {
            $doc = Document::create([
                'type' => 'component',
                'document_number' => self::tempDocNumber('component'),
                'component_id' => $component->id,
                'document_no' => null,
                'document_date' => now()->toDateString(),
                'organization_structure' => optional(optional($asset->assignedTo)->department)->name,
                'position' => optional($asset->assignedTo)->jobtitle,
                'location' => optional($asset->location)->name,
                'requestor_user_id' => null,
                'nama_penerima' => optional($asset->assignedTo)->present()?->fullName,
                'catatan' => $note,
                // Component specific
                'component_model' => $component->name,
                'component_part_number' => $component->model_number,
                'component_serial_number' => $component->serial,
                'component_spec' => $component->notes,
                'overall_status' => 'pending',
                'created_by' => $creator->id,
            ]);
            // Signatures: creator & user
            foreach ([
                ['role'=>'creator','user'=>$creator,'ordering'=>1],
                ['role'=>'user','user'=>$asset->assignedTo,'ordering'=>2],
            ] as $sig) {
                if (!$sig['user']) continue;
                DocumentSignature::create([
                    'document_id'=>$doc->id,
                    'role'=>$sig['role'],
                    'user_id'=>$sig['user']->id,
                    'user_name'=>$sig['user']->present()?->fullName,
                    'ordering'=>$sig['ordering'],
                ]);
            }
            return $doc;
        });
    }

    /**
     * Create a document from an accessory checkout to a user/asset/location.
     */
    public static function fromAccessoryCheckout(Accessory $accessory, $target, User $creator, ?string $note = null, bool $create = true): ?Document
    {
        if (!$create) return null;
        return DB::transaction(function () use ($accessory,$target,$creator,$note) {
            if ($target instanceof Asset) {
                $locationName = optional($target->location)->name;
                $receiverName = optional($target->assignedTo)->present()?->fullName;
            } elseif ($target instanceof User) {
                $locationName = optional($target->present())->location;
                $receiverName = $target->present()?->fullName;
            } elseif ($target instanceof Location) {
                $locationName = $target->name;
                $receiverName = null;
            } else {
                $locationName = null; $receiverName = null;
            }
            $doc = Document::create([
                'type' => 'accessory',
                'document_number' => self::tempDocNumber('accessory'),
                'accessory_id' => $accessory->id,
                'document_date' => now()->toDateString(),
                'location' => $locationName,
                'nama_penerima' => $receiverName,
                'accessory_part_number' => $accessory->order_number,
                'accessory_serial_number' => $accessory->serial,
                'accessory_condition' => null,
                'accessory_notes' => $accessory->notes,
                'catatan' => $note,
                'overall_status' => 'pending',
                'created_by' => $creator->id,
            ]);
            $sigRows = [ ['role'=>'creator','user'=>$creator,'ordering'=>1] ];
            $userForSig = null;
            if ($target instanceof Asset) { $userForSig = $target->assignedTo; }
            elseif ($target instanceof User) { $userForSig = $target; }
            // If checkout target is a Location, skip 'user' signature
            if ($userForSig) { $sigRows[] = ['role'=>'user','user'=>$userForSig,'ordering'=>2]; }
            foreach ($sigRows as $sig) {
                if (!$sig['user']) continue;
                DocumentSignature::create([
                    'document_id'=>$doc->id,
                    'role'=>$sig['role'],
                    'user_id'=>$sig['user']->id,
                    'user_name'=>$sig['user']->present()?->fullName,
                    'ordering'=>$sig['ordering'],
                ]);
            }
            return $doc;
        });
    }

    /**
     * Create a document from a consumable checkout to a user.
     */
    public static function fromConsumableCheckout(Consumable $consumable, User $user, User $creator, int $qty = 1, ?string $note = null, bool $create = true): ?Document
    {
        if (!$create) return null;
        return DB::transaction(function () use ($consumable,$user,$creator,$qty,$note) {
            $doc = Document::create([
                'type' => 'consumable',
                'document_number' => self::tempDocNumber('consumable'),
                'document_date' => now()->toDateString(),
                'location' => optional($user->present())->location,
                'nama_penerima' => $user->present()?->fullName,
                'consumable_batch' => $consumable->order_number,
                'consumable_qty' => $qty,
                'consumable_unit' => 'pcs',
                'consumable_notes' => $consumable->notes,
                'catatan' => $note,
                'overall_status' => 'pending',
                'created_by' => $creator->id,
            ]);
            foreach ([
                ['role'=>'creator','user'=>$creator,'ordering'=>1],
                ['role'=>'user','user'=>$user,'ordering'=>2],
            ] as $sig) {
                if (!$sig['user']) continue;
                DocumentSignature::create([
                    'document_id'=>$doc->id,
                    'role'=>$sig['role'],
                    'user_id'=>$sig['user']->id,
                    'user_name'=>$sig['user']->present()?->fullName,
                    'ordering'=>$sig['ordering'],
                ]);
            }
            return $doc;
        });
    }

    /**
     * Create a document from a license seat checkout to a user/asset.
     */
    public static function fromLicenseCheckout(LicenseSeat $seat, User|Asset $target, User $creator, ?string $note = null, bool $create = true): ?Document
    {
        if (!$create) return null;
        $license = $seat->license;
        return DB::transaction(function () use ($license,$seat,$target,$creator,$note) {
            $locationName = $target instanceof Asset ? optional($target->location)->name : optional($target->present())->location;
            $receiverName = $target instanceof Asset ? optional($target->assignedTo)->present()?->fullName : optional($target)->present()?->fullName;
            $doc = Document::create([
                'type' => 'license',
                'document_number' => self::tempDocNumber('license'),
                'license_id' => $license->id,
                'document_date' => now()->toDateString(),
                'location' => $locationName,
                'nama_penerima' => $receiverName,
                'license_key' => $license->serial,
                'license_seats' => $license->seats,
                'license_vendor' => optional($license->manufacturer)->name,
                'license_expires_at' => $license->expiration_date,
                'catatan' => $note,
                'overall_status' => 'pending',
                'created_by' => $creator->id,
            ]);
            foreach ([
                ['role'=>'creator','user'=>$creator,'ordering'=>1],
                ['role'=>'user','user'=>$target instanceof Asset ? $target->assignedTo : $target,'ordering'=>2],
            ] as $sig) {
                if (!$sig['user']) continue;
                DocumentSignature::create([
                    'document_id'=>$doc->id,
                    'role'=>$sig['role'],
                    'user_id'=>$sig['user']->id,
                    'user_name'=>$sig['user']->present()?->fullName,
                    'ordering'=>$sig['ordering'],
                ]);
            }
            return $doc;
        });
    }
}
