<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use App\Models\{User, Asset, Component, Accessory, Consumable, License, LicenseSeat, Location};
use App\Services\DocumentCreator;

class DocumentSeedNonAsset extends Command
{
    protected $signature = 'doc:seed-nonasset {--fresh-seed : Run SinglePerTypeSeeder first}';
    protected $description = 'Generate one test Document for each non-asset type (component, accessory, consumable, license)';

    public function handle(): int
    {
        if ($this->option('fresh-seed')) {
            try {
                Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\SinglePerTypeSeeder']);
                $this->info('Ran SinglePerTypeSeeder.');
            } catch (\Throwable $e) {
                $this->warn('Seeding helper failed: '.$e->getMessage());
            }
        }

        $creator = User::orderBy('id')->first();
        if (!$creator) {
            $this->error('No users found. Please create a user first.');
            return self::FAILURE;
        }

        // Ensure we have a receiver user and a location
        $receiver = User::orderBy('id', 'desc')->first() ?: $creator;
        $location = Location::orderBy('id')->first();

        // Component → needs an Asset (prefer assigned to receiver)
        $asset = Asset::first();
        if (!$asset) {
            $this->warn('No asset found; component doc will be created with available relations.');
        } else {
            if ($receiver && (!$asset->assigned_to || $asset->assigned_to !== $receiver->id)) {
                $asset->assigned_to = $receiver->id;
                // Ensure morph type is correct so $asset->assignedTo resolves
                $asset->assigned_type = \App\Models\User::class;
                if ($location && !$asset->location_id) { $asset->location_id = $location->id; }
                if ($location && !$asset->rtd_location_id) { $asset->rtd_location_id = $location->id; }
                $asset->save();
            }
        }

        $component = Component::first();
        if ($component && $asset) {
            $doc = DocumentCreator::fromComponentCheckout($component, $asset, $creator, 'Seeded component checkout', true);
            $this->info('Component doc id: '.($doc?->id ?? 'n/a'));
        } else {
            $this->warn('Skip component doc (missing component or asset).');
        }

        // Accessory → to user if possible
        $accessory = Accessory::first();
        if ($accessory) {
            $doc = DocumentCreator::fromAccessoryCheckout($accessory, $receiver ?: ($asset ?: $location), $creator, 'Seeded accessory checkout', true);
            $this->info('Accessory doc id: '.($doc?->id ?? 'n/a'));
        } else {
            $this->warn('Skip accessory doc (no accessory).');
        }

        // Consumable → to receiver
        $consumable = Consumable::first();
        if ($consumable && $receiver) {
            $doc = DocumentCreator::fromConsumableCheckout($consumable, $receiver, $creator, 1, 'Seeded consumable checkout', true);
            $this->info('Consumable doc id: '.($doc?->id ?? 'n/a'));
        } else {
            $this->warn('Skip consumable doc (missing consumable or user).');
        }

        // License → create/ensure one seat, assign to receiver, generate doc
        $license = License::with('manufacturer')->first();
        if ($license && $receiver) {
            // Avoid mass-assignment issues: set attributes directly
            $seat = LicenseSeat::where('license_id',$license->id)->where('assigned_to',$receiver->id)->first();
            if (!$seat) {
                $seat = new LicenseSeat();
                $seat->license_id = $license->id;
                $seat->assigned_to = $receiver->id;
                $seat->save();
            }
            $doc = \App\Services\DocumentCreator::fromLicenseCheckout($seat, $receiver, $creator, 'Seeded license checkout', true);
            $this->info('License doc id: '.($doc?->id ?? 'n/a'));
        } else {
            $this->warn('Skip license doc (missing license or user).');
        }

        $this->info('Done.');
        return self::SUCCESS;
    }
}
