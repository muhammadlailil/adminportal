<?php
namespace Laililmahfud\Adminportal\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\info;

class AdminPortalMigrationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminportal:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Portal migration command';

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
     */
    public function handle()
    {
        info('Run migrating adminportal database...');
        $rootProject = getcwd() . '\\';
        $this->call('migrate', [
            '--path' => [
               str_replace($rootProject, '', __DIR__ . '/../../../database/migrations/2025_02_11_132210_create_cms_role_permissions.php'),
               str_replace($rootProject, '', __DIR__ . '/../../../database/migrations/2025_02_11_132308_create_cms_admins_table.php'),
            ],
        ]);
    }
}
