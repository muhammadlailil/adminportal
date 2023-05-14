<?php

namespace Laililmahfud\Adminportal\Commands;

use Illuminate\Console\Command;

class AdminPortalInstallationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminportal:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Portal installation command';

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
        $this->createIndexController();

        $this->call('adminportal:api-key');
        $this->call('vendor:publish', ['--provider' => 'Laililmahfud\Adminportal\AdminPortalServiceProvider']);
        $this->call('vendor:publish', ['--tag' => 'portal-lang', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'portal-config', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'portal-asset', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'apdoc-config', '--force' => true]);

        $this->createSymlink();
        $this->createPartialAssetFile();

        $this->call('adminportal:migration');
    }

    protected function createIndexController()
    {
        $controllerDir = app_path('Http/Controllers/Admin');
        if (!file_exists($controllerDir)) {
            @mkdir($controllerDir, 0755);
        }
        if (!file_exists("{$controllerDir}/AdminIndexController.php")) {
            $controllerTemplate = file_get_contents(__DIR__ . '/../../stubs/AdminIndexController.php.stub');
            file_put_contents($controllerDir . '/AdminIndexController.php', $controllerTemplate);
        }
    }


    protected function createSymlink()
    {
        /**Create upload symlink */
        $uploadDir = storage_path('app/uploads');
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0755);
        }
        app('files')->link(storage_path('app/uploads'), public_path('uploads'));
    }

    protected function createPartialAssetFile()
    {
        $partials_dir = resource_path('views/admin/partials');
        if (!file_exists($partials_dir)) {
            @mkdir($partials_dir, 0755);
        }
        if (!file_exists("$partials_dir/js.blade.php")) {
            file_put_contents("$partials_dir/js.blade.php", '');
        }
        if (!file_exists("$partials_dir/css.blade.php")) {
            file_put_contents("$partials_dir/css.blade.php", '');
        }
    }
}