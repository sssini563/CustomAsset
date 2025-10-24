<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class ResetBranding extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:branding-reset {--yes : Run without confirmation prompt}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Snipe-IT branding (logo, skin, favicon) back to stock defaults without touching other settings.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        if (!$this->option('yes')) {
            if (!$this->confirm('This will reset branding (logo/email logo/label logos/favicon, brand style, skin) to stock Snipe-IT defaults. Continue?')) {
                $this->info('Aborted. No changes made.');
                return self::SUCCESS;
            }
        }

        $settings = Setting::first();
        if (!$settings) {
            $this->error('Settings record not found. Have you run the installer/migrations?');
            return self::FAILURE;
        }

        // Ensure demo stock logos exist in public storage
        try {
            $demoLogoSmall = public_path('img/demo/snipe-logo.png');
            $demoLogoLarge = public_path('img/demo/snipe-logo-lg.png');

            if (is_readable($demoLogoSmall)) {
                Storage::disk('public')->put('snipe-logo.png', file_get_contents($demoLogoSmall));
            }
            if (is_readable($demoLogoLarge)) {
                Storage::disk('public')->put('snipe-logo-lg.png', file_get_contents($demoLogoLarge));
            }
        } catch (\Throwable $e) {
            $this->warn('Could not copy stock demo logos: '.$e->getMessage());
        }

        // Reset only branding-related settings
        $settings->brand = 2; // show logo
        $settings->logo = 'snipe-logo.png';
        $settings->email_logo = null;
        $settings->label_logo = null;
        $settings->acceptance_pdf_logo = null;
        $settings->favicon = null;
        $settings->header_color = null;
        $settings->skin = '';
        $settings->allow_user_skin = 0;

        $settings->save();

        $this->info('Branding has been reset to stock Snipe-IT defaults.');
        $this->line('If the UI still looks customized, clear caches and rebuild front-end assets if necessary.');

        return self::SUCCESS;
    }
}
