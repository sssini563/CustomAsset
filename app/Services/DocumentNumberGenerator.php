<?php
namespace App\Services;

use App\Models\{Asset, Document};
use Illuminate\Support\Facades\DB;

/**
 * Document number generator.
 *
 * Requirement: If asset location is FAC then number is FAC + 3-digit sequence, else HO + 3-digit.
 * Sequence is per-prefix and monotonically increasing based on existing records.
 */
class DocumentNumberGenerator
{
    /**
     * Generate a document number for any document type. For assets, keep FAC/HO###.
     * For non-asset types, format as: "{Location} - {TYPE} - {id}".
     */
    public static function generateForDocument(Document $document): string
    {
        $type = strtolower((string) $document->type);
        if ($type === 'asset') {
            if ($document->asset) {
                return self::generateForAsset($document->asset);
            }
            // Fallback if asset missing
            return 'HO000';
        }

        $location = trim((string) ($document->location
            ?: optional(optional($document->asset)->location)->name
            ?: 'HO'));
        $label = self::nonAssetTypeLabel($type);
        $id = (int) ($document->id ?? 0);
        return rtrim($location). ' - '. $label . ' - ' . $id;
    }

    /**
     * Map internal type slugs to display labels for non-asset.
     */
    protected static function nonAssetTypeLabel(string $type): string
    {
        return match ($type) {
            'component'   => 'COMPONENT',
            'license'     => 'LICENSE',
            'consumable'  => 'CONSUMABLE',
            'accessory'   => 'ACCESSORIES',
            default       => strtoupper($type),
        };
    }
    /**
     * Generate a document number for a given asset based on its location.
     * FAC### when asset's location contains "FAC" (case-insensitive), otherwise HO###.
     */
    public static function generateForAsset(Asset $asset): string
    {
        $locName = trim((string) optional($asset->location)->name);
        $prefix = (stripos($locName, 'FAC') !== false) ? 'FAC' : 'HO';

        // Compute next 3-digit sequence for this prefix by scanning existing numbers with the same prefix
        // Pattern strictly matches PREFIXNNN where N is digit.
        $latest = Document::query()
            ->where('type', 'asset')
            ->where('document_number', 'like', $prefix.'%')
            ->orderBy('id', 'desc')
            ->value('document_number');

        $next = 1;
        if (is_string($latest)) {
            if (preg_match('/^'.preg_quote($prefix,'/').'([0-9]{3})$/', $latest, $m)) {
                $next = ((int) $m[1]) + 1;
            } else {
                // Fallback: search max numeric suffix for the prefix among last 100 entries to be safe
                $candidates = Document::query()
                    ->where('type','asset')
                    ->where('document_number','like',$prefix.'%')
                    ->orderBy('id','desc')
                    ->limit(100)
                    ->pluck('document_number');
                $max = 0;
                foreach ($candidates as $num) {
                    if (preg_match('/^'.preg_quote($prefix,'/').'([0-9]{3})$/', (string)$num, $mm)) {
                        $val = (int) $mm[1];
                        if ($val > $max) { $max = $val; }
                    }
                }
                $next = $max + 1;
            }
        }
        if ($next < 1) { $next = 1; }
        return $prefix . str_pad((string)$next, 3, '0', STR_PAD_LEFT);
    }
}
