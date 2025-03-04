<?php

namespace Laililmahfud\Adminportal\Console\Commands;

use Illuminate\Console\Command;
use function Laravel\Prompts\info;
use function Laravel\Prompts\password;
use function Laravel\Prompts\text;


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
        $this->call('icons:cache');
        $account = $this->askAccountCredential();

        info("Successfully published assets!");
        // $this->info($account->name);
        // $this->info($account->email);
        // $this->info($account->password);
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
}
