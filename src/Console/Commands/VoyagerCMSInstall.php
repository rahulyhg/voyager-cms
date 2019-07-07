<?php

namespace Tjventurini\VoyagerCMS\Console\Commands;

use Illuminate\Console\Command;

class VoyagerCMSInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'voyager-cms:install {--force : Wether the whole project should be refreshed.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Voyager CMS.';

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
        // check if we are in producton
        if (config('app.env') == 'production') {
            // if so, print error message
            $this->error('You are in production mode!');
            // terminate command with error state (>0)
            return 1;
        }

        // install voyager
        $this->installVoyager();

        // provision the packages
        $this->provisionPackages();

        // run migrations
        $this->runMigrations();

        // run seeders
        $this->runSeeders();

        // clear cache
        $this->call('cache:clear');
    }

    /**
     * Run the seeders.
     *
     * @return void
     */
    private function runSeeders(): void
    {
        // voyager
        $this->call('db:seed', ['--class' => "VoyagerDatabaseSeeder"]);

        // tags
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerTags\Seeds\VoyagerTagsDatabaseSeeder"]);

        // projects
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerProjects\Seeds\VoyagerProjectsDatabaseSeeder"]);

        // pages
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerPages\Seeds\VoyagerPagesDatabaseSeeder"]);

        // posts
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerPosts\Seeds\VoyagerPostsDatabaseSeeder"]);

        // content blocks
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerContentBlocks\Seeds\VoyagerContentBlocksDatabaseSeeder"]);

        // content blocks
        $this->call('db:seed', ['--class' => "Tjventurini\VoyagerCMS\Seeds\VoyagerCMSDatabaseSeeder"]);

        // default seeders
        // - we run them last because they could depend on other seeders to be run first
        $this->call('db:seed');
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    private function runMigrations(): void
    {
        // get force value
        $force = $this->option('force');

        // if force flag is set we want to refresh the migrations
        if ($force) {
            $this->call('migrate:refresh');
            return;
        }

        // otherwise we run normal migrations
        $this->call('migrate');
    }

    /**
     * Provision the packages.
     *
     * @return void
     */
    private function provisionPackages(): void
    {
        // tags
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerTags\VoyagerTagsServiceProvider", '--tag' => 'config']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerTags\VoyagerTagsServiceProvider", '--tag' => 'views']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerTags\VoyagerTagsServiceProvider", '--tag' => 'lang']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerTags\VoyagerTagsServiceProvider", '--tag' => 'graphql']);

        // projects
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerProjects\VoyagerProjectsServiceProvider", '--tag' => 'config']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerProjects\VoyagerProjectsServiceProvider", '--tag' => 'views']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerProjects\VoyagerProjectsServiceProvider", '--tag' => 'lang']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerProjects\VoyagerProjectsServiceProvider", '--tag' => 'graphql']);

        // pages
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPages\VoyagerPagesServiceProvider", '--tag' => 'config']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPages\VoyagerPagesServiceProvider", '--tag' => 'views']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPages\VoyagerPagesServiceProvider", '--tag' => 'lang']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPages\VoyagerPagesServiceProvider", '--tag' => 'graphql']);

        // posts
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPosts\VoyagerPostsServiceProvider", '--tag' => 'config']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPosts\VoyagerPostsServiceProvider", '--tag' => 'views']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPosts\VoyagerPostsServiceProvider", '--tag' => 'lang']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerPosts\VoyagerPostsServiceProvider", '--tag' => 'graphql']);

        // content blocks
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerContentBlocks\VoyagerContentBlocksServiceProvider", '--tag' => 'config']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerContentBlocks\VoyagerContentBlocksServiceProvider", '--tag' => 'views']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerContentBlocks\VoyagerContentBlocksServiceProvider", '--tag' => 'lang']);
        $this->customCall('vendor:publish', ['--provider' => "Tjventurini\VoyagerContentBlocks\VoyagerContentBlocksServiceProvider", '--tag' => 'graphql']);
    }

    /**
     * Install the voyager admin panel.
     *
     * @return void
     */
    private function installVoyager(): void
    {
        $this->call('voyager:install');
    }

    /**
     * Run command but check for force flag and append if set.
     *
     * @param  string $command
     *
     * @return void
     */
    public function customCall(string $command, array $options = []): void
    {
        // get force value
        $force = $this->option('force');

        // append force flag if force flag is set
        if ($force) {
            $options['--force'] = true;
        }

        // run command
        $this->call($command, $options);
    }
}
