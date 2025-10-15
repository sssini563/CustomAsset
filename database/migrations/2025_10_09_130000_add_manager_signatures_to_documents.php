<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\{Document, DocumentSignature};

return new class extends Migration {
    public function up(): void
    {
        // For existing documents, ensure creator_manager and user_manager signatures exist (pending, null users)
        if (!class_exists(Document::class)) return; // safety
        Document::query()->chunkById(100, function($documents){
            foreach($documents as $document){
                $existingRoles = $document->signatures()->pluck('role')->all();
                $orderingBase = $document->signatures()->max('ordering') ?? 0;
                $toCreate = [];
                if (!in_array('creator_manager',$existingRoles)) {
                    $toCreate[] = ['role'=>'creator_manager','ordering'=>++$orderingBase];
                }
                if (!in_array('user_manager',$existingRoles)) {
                    $toCreate[] = ['role'=>'user_manager','ordering'=>++$orderingBase];
                }
                foreach($toCreate as $sig){
                    DocumentSignature::create([
                        'document_id'=>$document->id,
                        'role'=>$sig['role'],
                        'ordering'=>$sig['ordering'],
                        'status'=>'pending'
                    ]);
                }
            }
        });
    }
    public function down(): void
    {
        // Optional: remove empty manager signatures that have no user and are still pending
        DB::table('document_signatures')
            ->whereIn('role',['creator_manager','user_manager'])
            ->whereNull('user_id')
            ->where('status','pending')
            ->delete();
    }
};
