<?php

namespace Tests\Feature;

use App\Models\{User, Asset, Statuslabel, AssetModel, Manufacturer, Category, Document, DocumentSignature};
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentWorkflowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Minimal seed for asset dependencies
        $manufacturer = Manufacturer::factory()->create();
        $category = Category::factory()->create();
        $status = Statuslabel::factory()->create(['deployable'=>1,'archived'=>0]);
        $model = AssetModel::factory()->create(['manufacturer_id'=>$manufacturer->id,'category_id'=>$category->id]);
        Asset::factory()->create(['model_id'=>$model->id,'status_id'=>$status->id]);
    }

    public function test_document_created_on_checkout_with_flag(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $asset = Asset::first();

        // Simulasikan form checkout (langsung panggil route logic sederhana)
        $response = $this->post(route('hardware.checkout.store', $asset->id), [
            'name' => $asset->name,
            'status_id' => $asset->status_id,
            'checkout_to_type' => 'user',
            'assigned_user' => $user->id,
            'checkout_at' => date('Y-m-d'),
            'expected_checkin' => '',
            'note' => 'Test',
            'redirect_option' => 'item',
            'checkout_and_create_document' => 1,
        ]);

        $response->assertStatus(302);
        $this->assertDatabaseCount('documents',1);
        $doc = Document::first();
        $this->assertEquals('pending',$doc->overall_status);
        $this->assertCount(4,$doc->signatures);
    }

    public function test_sign_sequential_and_reject_flow(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $asset = Asset::first();
        // Create document manually for test simplicity
        $doc = Document::factory()->create(['type'=>'asset','asset_id'=>$asset->id,'document_number'=>'DOC-TEST-0001','created_by'=>$user->id]);
        foreach ([['creator',1],['it_manager',2],['user',3],['atasan_penerima',4]] as $row) {
            $doc->signatures()->create(['role'=>$row[0],'ordering'=>$row[1],'user_id'=>$user->id,'user_name'=>$user->first_name,'status'=>'pending']);
        }
        // Sign creator
        $this->postJson(route('documents.sign',['document'=>$doc->id,'role'=>'creator']))->assertOk();
        // Attempt to sign user before it_manager should fail ordering
        $this->postJson(route('documents.sign',['document'=>$doc->id,'role'=>'user']))->assertStatus(403);
        // Sign it_manager
        $this->postJson(route('documents.sign',['document'=>$doc->id,'role'=>'it_manager']))->assertOk();
        // Reject user signature
        $this->postJson(route('documents.reject',['document'=>$doc->id,'role'=>'user']))->assertOk();
        $doc->refresh();
        $this->assertEquals('rejected',$doc->overall_status);
    }
}
