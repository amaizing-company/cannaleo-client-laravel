<?php

namespace AmaizingCompany\CannaleoClient\Commands;

use Illuminate\Console\Command;

class CannaleoClientCommand extends Command
{
    public $signature = 'cannaleo-client-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
