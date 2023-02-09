<?php
namespace Laililmahfud\Adminportal\Commands;

use Illuminate\Console\Command;

class AdminPortalInstalationCommand extends Command
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
    protected $description = 'Admin Portal instalation command';

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
        $this->info('Migrating database...');
        $rootProject = getcwd() . '\\';
        $this->call('migrate', [
            '--path' => [
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2019_08_19_000000_create_failed_jobs_table.php'),
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2023_01_01_211100_create_roles_permission_table.php'),
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2023_01_01_211243_create_cms_admin_table.php'),
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2023_01_10_114353_create_jobs_table.php'),
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2023_01_10_191113_create_data_import_log_table.php'),
                str_replace($rootProject, '', __DIR__ . '/../Database/migrations/2023_01_16_083455_create_cms_moduls_table.php'),
            ],
        ]);
        $this->createIndexController();

        $this->call('adminportal:api-key');
        $this->call('db:seed', ['--class' => 'Laililmahfud\Adminportal\Database\seeders\AdminPortalSeeder']);
        $this->call('vendor:publish', ['--provider' => 'Laililmahfud\Adminportal\AdminPortalServiceProvider']);
        $this->call('vendor:publish', ['--tag' => 'portal-lang', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'portal-config', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'portal-asset', '--force' => true]);
        $this->call('vendor:publish', ['--tag' => 'apdoc-config', '--force' => true]);
        $this->info('Login infromation');
        $this->info('username : portal@admin.com');
        $this->info('password : P@ssw0rd');
        $this->info('Instalation success...');
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
}
