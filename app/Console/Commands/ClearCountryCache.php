<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCountryCache extends Command
{
    protected $signature = 'countries:clear-cache';

    protected $description = 'Flushes the RestCountries API cache';

    public function handle()
    {
        $this->info('Flushing API cache...');
        Cache::flush();
        $this->info('Country API cache cleared successfully! Fresh data will be fetched on next search.');
    }
}
