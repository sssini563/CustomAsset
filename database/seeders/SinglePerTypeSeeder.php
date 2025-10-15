<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Company, Department, Location, Manufacturer, Category, Statuslabel, AssetModel, Asset, Component, Accessory, Consumable, License};
use Illuminate\Support\Facades\Hash;

class SinglePerTypeSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::first() ?? Company::factory()->create(['name' => 'Demo Co']);
        $dept = Department::first() ?? Department::factory()->create(['name' => 'IT','company_id'=>$company->id]);
        $loc = Location::first() ?? Location::factory()->create(['name' => 'HQ','company_id'=>$company->id]);
        $microsoft = Manufacturer::first() ?? Manufacturer::factory()->microsoft();
        $status = Statuslabel::first() ?? Statuslabel::factory()->create(['name'=>'Ready','status_type'=>'deployable']);

        $user = User::where('email','onepertype@example.com')->first();
        if (!$user) {
            $user = User::factory()->create([
                'first_name' => 'One',
                'last_name' => 'PerType',
                'email' => 'onepertype@example.com',
                'company_id' => $company->id,
                'department_id' => $dept->id,
                'activated' => 1,
                'show_in_list' => 1,
            ]);
        }

        // Asset to exercise asset checkout if needed
        $model = AssetModel::first() ?? AssetModel::factory()->create([
            'name' => 'Demo Laptop','manufacturer_id'=>$microsoft->id,
            'category_id' => Category::factory()->create(['name'=>'Laptop','category_type'=>'asset'])->id,
        ]);
        Asset::firstOrCreate(['asset_tag'=>'DEMO-001'],[
            'name'=>'Demo Asset','model_id'=>$model->id,'serial'=>'SER-DEMO-001','status_id'=>$status->id,
            'company_id'=>$company->id,'location_id'=>$loc->id,'rtd_location_id'=>$loc->id,
        ]);

        // Component
        Component::firstOrCreate(['name'=>'Test Component'],[
            'company_id'=>$company->id,'location_id'=>$loc->id,'qty'=>10,
            'category_id'=> Category::factory()->create(['name'=>'Storage','category_type'=>'component'])->id,
            'model_number'=>'CMP-001','serial'=>'CMP-SN-001','notes'=>'NVMe SSD Test'
        ]);

        // Accessory
        Accessory::firstOrCreate(['name'=>'USB-C Hub'],[
            'company_id'=>$company->id,'qty'=>5,
            'category_id'=> Category::factory()->create(['name'=>'Hub','category_type'=>'accessory'])->id,
            'order_number' => 'PO-ACC-001','serial' => 'ACC-SN-001','notes' => 'Anker USB-C Hub'
        ]);

        // Consumable
        Consumable::firstOrCreate(['name'=>'Printer Toner'],[
            'company_id'=>$company->id,'qty'=>50,
            'category_id'=> Category::factory()->create(['name'=>'Toner','category_type'=>'consumable'])->id,
            'order_number'=>'BATCH-TONER','notes'=>'Black toner 80g'
        ]);

        // License
        License::firstOrCreate(['name'=>'Demo Office License'],[
            'company_id'=>$company->id,
            'seats'=>3,
            'serial'=>'LIC-DEMO-001',
            'manufacturer_id'=>$microsoft->id,
            'category_id'=> Category::factory()->create(['name'=>'Office Software','category_type'=>'license'])->id,
        ]);

        $this->command?->info('Seeded one item per type for quick checkout tests.');
    }
}
