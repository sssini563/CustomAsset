<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Document, DocumentSignature, User};
use Illuminate\Support\Str;

class DocumentSampleSeeder extends Seeder
{
    public function run(): void
    {
        // Find or create two users to assign roles
        $creator = User::where('email', 'creator@example.com')->first();
        if (!$creator) {
            $creator = User::factory()->create([
                'first_name' => 'Creator',
                'last_name' => 'Sample',
                'email' => 'creator@example.com',
                'activated' => 1,
            ]);
        }
        $receiver = User::where('email', 'receiver@example.com')->first();
        if (!$receiver) {
            $receiver = User::factory()->create([
                'first_name' => 'Receiver',
                'last_name' => 'Sample',
                'email' => 'receiver@example.com',
                'activated' => 1,
            ]);
        }

        // Helper to create a document with two signatures (creator, user)
        $makeDoc = function(array $attrs) use ($creator, $receiver) {
            $defaults = [
                'document_number' => 'DOC-'.strtoupper($attrs['type']).'-'.now()->format('Ymd').'-'.str_pad((string)random_int(1,9999),4,'0',STR_PAD_LEFT),
                'document_date' => now()->toDateString(),
                'overall_status' => 'pending',
                'created_by' => $creator->id,
                'requestor' => $creator->present()->fullName ?? ($creator->name ?? $creator->username ?? 'Creator Sample'),
                'nama_penerima' => $receiver->present()->fullName ?? ($receiver->name ?? $receiver->username ?? 'Receiver Sample'),
            ];
            $doc = new Document(array_merge($defaults, $attrs));
            $doc->save();

            // Signatures: creator, user (pending)
            $sigOrder = 1;
            foreach ([
                ['role' => 'creator', 'user' => $creator],
                ['role' => 'user', 'user' => $receiver],
            ] as $row) {
                DocumentSignature::create([
                    'document_id' => $doc->id,
                    'role' => $row['role'],
                    'user_id' => $row['user']->id,
                    'user_name' => $row['user']->present()->fullName ?? ($row['user']->name ?? $row['user']->username),
                    'status' => 'pending',
                    'ordering' => $sigOrder++,
                ]);
            }

            $this->command?->info('Created sample document: '.$doc->type.' #'.$doc->id.' ('.$doc->document_number.')');
            return $doc;
        };

        // License sample
        $makeDoc([
            'type' => 'license',
            'license_key' => 'LIC-'.Str::upper(Str::random(10)),
            'license_seats' => 25,
            'license_vendor' => 'Adobe',
            'license_expires_at' => now()->addMonths(18)->toDateString(),
        ]);

        // Accessory sample
        $makeDoc([
            'type' => 'accessory',
            'accessory_part_number' => 'PN-ACC-001',
            'accessory_serial_number' => 'ACC-SN-'.Str::upper(Str::random(6)),
            'accessory_condition' => 'New',
            'accessory_notes' => 'USB-C Docking Station',
        ]);

        // Component sample
        $makeDoc([
            'type' => 'component',
            'component_model' => 'NVMe SSD 1TB',
            'component_part_number' => 'COMP-PN-SSD1TB',
            'component_serial_number' => 'COMP-SN-'.Str::upper(Str::random(6)),
            'component_spec' => 'PCIe Gen4 x4, 7000MB/s read',
        ]);

        // Consumable sample
        $makeDoc([
            'type' => 'consumable',
            'consumable_batch' => 'BATCH-'.Str::upper(Str::random(5)),
            'consumable_qty' => 100,
            'consumable_unit' => 'pcs',
            'consumable_notes' => 'Printer Toner Black 80g',
        ]);
    }
}
