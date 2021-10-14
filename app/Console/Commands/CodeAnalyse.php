<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function is_string;

class CodeAnalyse extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'code:analyse {--memory-limit=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Larastanによる静的コード解析(optionは--memory-limitのみ指定可能)';

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
        $memoryLimit = $this->option('memory-limit');
        $option = $memoryLimit && is_string($memoryLimit) ? "--memory-limit=${memoryLimit}" : '';
        $this->info((string) shell_exec("vendor/bin/phpstan analyse ${option}"));

        return 0;
    }
}
