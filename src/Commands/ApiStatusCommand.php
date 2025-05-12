<?php

namespace AmaizingCompany\CannaleoClient\Commands;

use AmaizingCompany\CannaleoClient\Api\Requests\ApiStatusRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class ApiStatusCommand extends Command
{
    public $signature = 'cannaleo:status';

    public $description = 'Request the api status.';

    public function handle(): int
    {
        try {
            $request = new ApiStatusRequest();
            $response = $request->send()->throw();
        } catch (\Exception $exception) {
            $this->error($exception->getMessage());
            return self::FAILURE;
        }

        $uptimeInSeconds = $response->getUptime();

        $uptimeForHumans = \Carbon\CarbonInterval::seconds($uptimeInSeconds)->cascade()->forHumans();

        $this->newLine();
        $this->info($response->getLabel());
        $this->info('Uptime: ' . $uptimeForHumans . ' (' . $uptimeInSeconds . ' s)');
        $this->info('Version: ' . $response->getVersion());
        $this->newLine();

        return self::SUCCESS;
    }
}
