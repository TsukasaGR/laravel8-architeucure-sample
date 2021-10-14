<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CodeFix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:fix {--dry-run}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'PHP-CS-Fixerによるコード自動整形(optionは--dry-runのみ指定可能)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
        public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $option = $isDryRun ? "--dry-run" : '';
        $this->info((string) shell_exec("vendor/bin/php-cs-fixer fix --diff ${option}"));

        return 0;
    }
}
