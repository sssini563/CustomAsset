<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Services\DocumentNumberGenerator;

/**
 * Document model representing a checkout document with digital signatures.
 */
class Document extends Model
{
    use HasFactory;

    protected $fillable = [
    'type','asset_id','component_id','license_id','accessory_id','asset_log_id','document_number','document_no','organization_structure','position','location','requestor','document_date','requestor_user_id','checkout_user_name','nama_penerima','atasan_penerima_name','asset_number','gr_number','device_name','serial_number_device','merk','battery','type_device','serial_number_battery','processor','tas','memory','adaptor','hardisk','serial_number_adaptor','serial_number','foto_device','windows','browser','office','other_application_1','other_application_2','other_application_3','other_application_4','antivirus','compress_tools','reader_tool','dokumen_pengembalian_asset','dokumen_surat_pernyataan','catatan','doc_control_no','created_doc','effective_doc','revision_no','revision_date','author_doc','overall_status','pdf_path','completed_at','created_by',
    // License fields
    'license_key','license_seats','license_vendor','license_expires_at',
    // Accessory fields
    'accessory_part_number','accessory_serial_number','accessory_condition','accessory_notes',
    // Component fields
    'component_model','component_part_number','component_serial_number','component_spec',
    // Consumable fields
    'consumable_batch','consumable_qty','consumable_unit','consumable_notes'
    ];

    protected $casts = [
        'document_date' => 'date',
        'created_doc' => 'date',
        'effective_doc' => 'date',
        'revision_date' => 'date',
        'completed_at' => 'datetime',
        'license_expires_at' => 'date',
    ];

    /* Relationships */
    public function asset(): BelongsTo { return $this->belongsTo(Asset::class); }
    public function creator(): BelongsTo { return $this->belongsTo(User::class,'created_by'); }
    public function signatures(): HasMany { return $this->hasMany(DocumentSignature::class); }
    public function requestor(): BelongsTo { return $this->belongsTo(User::class,'requestor_user_id'); }
    public function actionLog(): BelongsTo { return $this->belongsTo(Actionlog::class,'asset_log_id'); }

    public function scopeType($query, string $type) { return $query->where('type',$type); }
    public function scopeStatus($query, string $status) { return $query->where('overall_status',$status); }

    public function getSignature(string $role): ?DocumentSignature
    {
        return $this->signatures()->where('role', $role)->first();
    }

    // Accessor: For non-asset types, display No Tanda Terima as "{Location} - {TYPE} - {id}"
    public function getDocumentNumberAttribute($value)
    {
        $type = strtolower((string) $this->attributes['type'] ?? ($this->type ?? 'asset'));
        if ($type !== 'asset') {
            try {
                return DocumentNumberGenerator::generateForDocument($this);
            } catch (\Throwable $e) {
                // Fallback to stored when generator fails
                return $value;
            }
        }
        return $value;
    }

    public function updateOverallStatus(): void
    {
        // If document already locked as complete (has completed_at or pdf_path), ensure status is 'complete'
        if (!empty($this->completed_at) || !empty($this->pdf_path)) {
            if ($this->overall_status !== 'complete') {
                $this->overall_status = 'complete';
                $this->save();
            }
            return;
        }
        // Always reload signatures to avoid using stale cached relations after a sign/reject
        $this->load('signatures');
        // Two-state model: pending|complete.
        // Revised to: pending|complete_sign|complete
        // Auto-set to complete_sign when all assigned non-legacy steps are signed and not locked; else pending.
        // Ensure we have freshest signatures collection
        $nonLegacy = $this->signatures->reject(fn($s)=> in_array($s->role,['it_manager','atasan_penerima']));
        $assigned = $nonLegacy->filter(fn($s)=> !is_null($s->user_id));
        if ($assigned->count() > 0 && $assigned->where('status','signed')->count() === $assigned->count()) {
            $this->overall_status = 'complete_sign';
        } else {
            $this->overall_status = 'pending';
        }
        $this->save();
    }
}
