<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Repository file';

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
        $name = $this->argument('name');
        $path = app_path('Repositories/' . $name . '.php');

        $templatePath = resource_path('templates/repository.stub');
        if (!file_exists($templatePath)) {
            $this->error('Template file not found:' . $templatePath);
            return ;
        }

        $template = file_get_contents($templatePath);
        $template = str_replace('{{fileName}}' , $name , $template);

        file_put_contents($path, $template);

        $this->info('repository file created successfully at' . $path);



    }
}
