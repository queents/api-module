<?php

namespace Modules\API\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Modules\API\Helpers\ApiGenerator;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;

class CreateApiCrudCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'vilt:api';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Full Api Crud To This Module ';

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
     * @return mixed
     */
    public function handle()
    {
        $table = $this->ask('Please input your table name? EX: users');
        $module = $this->ask('Please Input your module name? EX: Blog');

        $check = Module::find($module);
        if (!$check) {
            $this->error('Module not exists we will create it for you');
            exit;
        }
        try {


            $newGenerator = new ApiGenerator($table, $module);
            $newGenerator->generateApi();

            $this->line('<fg=green>Api Created Sueccssfuly :)</>');
            $this->line('<fg=green>Please Go To Your Module And Register InterFace And Repository In App Providers AppServiceProvider register() function </>');
            $this->line('<fg=green>Example</>');
            $this->line('
            <fg=white>
$this->app->bind(
    '.Str::ucfirst(Str::camel(Str::singular($table))).'RepositoryInterface::class,
    '.Str::ucfirst(Str::camel(Str::singular($table))).'Repository::class
);
            </>');
            $this->line('<fg=green>Thank You</>');



            // $this->info('Generated Full Crud Api For' .' '. $module .' '.$table );

        } catch (Exception $e) {
            $this->error($e);
        }

        return Command::SUCCESS;

    }

}
