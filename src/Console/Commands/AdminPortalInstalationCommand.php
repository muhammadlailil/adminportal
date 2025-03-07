<?php

namespace Laililmahfud\Adminportal\Console\Commands;

use Illuminate\Console\Command;
use Laililmahfud\Adminportal\Enums\UserStatus;
use function Laravel\Prompts\info;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\password;
use Laililmahfud\Adminportal\Models\CmsAdmin;


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
    protected $description = 'Admin Portal installation command';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $logo = <<<ASCII
        ___       __          _          ____             __        __
        /   | ____/ /___ ___  (_)___     / __ \____  _____/ /_____ _/ /
       / /| |/ __  / __ `__ \/ / __ \   / /_/ / __ \/ ___/ __/ __ `/ / 
      / ___ / /_/ / / / / / / / / / /  / ____/ /_/ / /  / /_/ /_/ / /  
     /_/  |_\__,_/_/ /_/ /_/_/_/ /_/  /_/    \____/_/   \__/\__,_/_/   
                                                                       
   ASCII;
        info($logo);
        $this->publishStub();
        $this->call('adminportal:migration');
        info("Create permission ...");
        $this->call('db:seed', ['--class' => 'Laililmahfud\Adminportal\Seeders\AdminCmsRolePermissionSeeder']);
        $account = $this->askAccountCredential();
        CmsAdmin::create([
            'name' => $account->name,
            'email' => $account->email,
            'role_permission_id' => 1,
            'status' => UserStatus::Active,
            'email_verified_at' => now(),
            'password' => Hash::make($account->password)
       ]);
       $this->call('icons:cache');
       $this->call('vendor:publish', ['--tag' => 'portal:lang', '--force' => true]);
       $this->call('vendor:publish', ['--tag' => 'portal:config', '--force' => true]);
       $this->call('vendor:publish', ['--tag' => 'portal:asset', '--force' => true]);
       info('Instalation finished, now you can login whit your account.');
    }

    private function askAccountCredential()
    {
        $name = text(
            label: 'What is your name?',
            required: true
        );
        $email = text(
            label: 'Enter an email to login?',
            placeholder: 'E.g: yourname@example.com',
            hint: 'We will use this email to create your admin account.',
            validate: [
                'email' => 'email'
            ],
            required: true
        );
        $password = text(
            label: 'Enter your account password?',
            placeholder: 'password',
            hint: 'You will use this for next login.',
            validate: ['password' => 'min:8'],
            required: true
        );

        return (object) [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];
    }

    private function publishStub()
    {
        // Publish dashboard controller
        info("Generate controller ...");
        $controllerDir = app_path('Http/Controllers/Admin');
        if (!file_exists($controllerDir)) {
            @mkdir($controllerDir, 0755);
        }

        if (!file_exists("{$controllerDir}/AdminDashboardController.php")) {
            $controllerTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Controllers/Admin/AdminDashboardController.php.stub');
            file_put_contents($controllerDir . '/AdminDashboardController.php', $controllerTemplate);
        }

        // Publish dashboard view
        info("Generate views ...");
        $adminModuleDir = resource_path('views/admin');
        if (!file_exists($adminModuleDir)) {
            @mkdir($adminModuleDir, 0755);
        }
        if (!file_exists("{$adminModuleDir}/dashboard.blade.php")) {
            $dashboardViewtemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/views/admin/dashboard.blade.php.stub');
            file_put_contents($adminModuleDir . '/dashboard.blade.php', $dashboardViewtemplate);
        }

        // Publish admin layout component
        $componentsDir = resource_path('views/components');
        if (!file_exists($componentsDir)) {
            @mkdir($componentsDir, 0755);
        }
        if (!file_exists("{$componentsDir}/admin.blade.php")) {
            $adminLayoutComponent = file_get_contents(__DIR__ . '/../../../resources/stubs/views/components/admin.blade.php.stub');
            file_put_contents($componentsDir . '/admin.blade.php', $adminLayoutComponent);
        }
    }

}
