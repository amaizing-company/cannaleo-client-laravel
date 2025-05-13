<?php

namespace AmaizingCompany\CannaleoClient\Commands;

use AmaizingCompany\CannaleoClient\Facades\CannaleoClient;
use Illuminate\Console\Command;
use Throwable;

class SyncDataCommand extends Command
{
    protected $signature = 'cannaleo:sync';

    protected $description = 'Synchronize data from cannaleo api with database';

    public function handle()
    {
        $this->line('Syncing cannaleo data...');

        try {
            CannaleoClient::syncPharmacies();
            CannaleoClient::syncCatalog();
        } catch (Throwable $e) {
            $this->error($e->getMessage());

            return Command::FAILURE;
        }

        $this->newLine();
        $this->info("Sync data successfully completed.");

        return Command::SUCCESS;
    }
}
