<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Asset, Company, Department, Manufacturer, Location, Statuslabel, Category, AssetModel};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MinimalTestSeeder extends Seeder
{
    public function run(): void
    {
        // Ensure supporting records (very small subset)
        $company = Company::first() ?? Company::factory()->create(['name' => 'Test Company']);
        $department = Department::first() ?? Department::factory()->create(['name' => 'IT', 'company_id'=>$company->id]);
        $location = Location::first() ?? Location::factory()->create(['name' => 'HQ','company_id'=>$company->id]);
        $manufacturer = Manufacturer::first() ?? Manufacturer::factory()->create(['name'=>'Lenovo']);
        $category = Category::first() ?? Category::factory()->create(['name'=>'Laptop','category_type'=>'asset']);
        $status = Statuslabel::first() ?? Statuslabel::factory()->create(['name'=>'Ready','status_type'=>'deployable','show_in_nav'=>1]);
        $model = AssetModel::first() ?? AssetModel::factory()->create([
            'name' => 'IdeaPad 320',
            'category_id' => $category->id,
            'manufacturer_id' => $manufacturer->id,
            'model_number' => 'IDP-320'
        ]);

        // Create single test user (receiver) if not exists
        $testUser = User::where('email','tester@example.com')->first();
        if (!$testUser) {
            $testUser = new User([
                'first_name' => 'Test',
                'last_name' => 'User',
                'username' => 'testuser',
                'email' => 'tester@example.com',
                'password' => Hash::make('password'),
                'company_id' => $company->id,
                'department_id' => $department->id,
                'activated' => 1,
                'show_in_list' => 1,
            ]);
            // permissions is hidden/not fillable; set via attribute directly (expects serialized JSON string in DB layer for Snipe-IT legacy)
            $testUser->permissions = json_encode(['superuser' => 0]);
            $testUser->save();
        }

        // Minimal asset ready for checkout
        $asset = Asset::where('asset_tag','TEST-ASSET-001')->first();
        if (!$asset) {
            $asset = new Asset([
                'asset_tag' => 'TEST-ASSET-001',
                'name' => 'Laptop Test Asset',
                'model_id' => $model->id,
                'serial' => 'SN-TST-001',
                'status_id' => $status->id,
                'purchase_date' => now()->toDateString(),
                'company_id' => $company->id,
                'location_id' => $location->id,
                'rtd_location_id' => $location->id,
                'created_by' => $testUser->id,
            ]);
            $asset->save();
        }

        $this->command?->info('Minimal test user & asset seeded: user='.$testUser->email.' asset_tag='.$asset->asset_tag);
    }
}
