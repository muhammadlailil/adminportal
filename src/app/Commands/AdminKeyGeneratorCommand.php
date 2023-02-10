<?php
namespace Laililmahfud\Adminportal\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;

class AdminKeyGeneratorCommand extends Command{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adminportal:api-key';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Admin Portal generate api key';

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
        $this->apiSecretKey();
        $this->jwtSecretKey();
    }

    protected function jwtSecretKey(){
        $key = Str::random(64);

        if (file_exists($path = $this->envPath()) === false) {
            $this->info("jwt secret [$key] set successfully.");
        }else{
            if (Str::contains(file_get_contents($path), 'JWT_SECRET_KEY') === false) {
                // create new entry
                file_put_contents($path, "JWT_SECRET_KEY=$key".PHP_EOL, FILE_APPEND);
            } else {
    
                // update existing entry
                file_put_contents($path, str_replace(
                    'JWT_SECRET_KEY='.portal_config('api.jwt_secret_key'),
                    'JWT_SECRET_KEY='.$key, file_get_contents($path)
                ));
            }
    
            $this->info("jwt secret [$key] set successfully.");
        }
    }

    protected function apiSecretKey(){
        $key = Str::random(30);

        if (file_exists($path = $this->envPath()) === false) {
            $this->info("api secret [$key] set successfully.");
        }else{
            if (Str::contains(file_get_contents($path), 'API_SECRET_KEY') === false) {
                // create new entry
                file_put_contents($path, PHP_EOL."API_SECRET_KEY=$key".PHP_EOL, FILE_APPEND);
            } else {
    
                // update existing entry
                file_put_contents($path, str_replace(
                    'API_SECRET_KEY='.portal_config('api.secret_key'),
                    'API_SECRET_KEY='.$key, file_get_contents($path)
                ));
            }
    
            $this->info("api secret [$key] set successfully.");
        }
        
    }

     /**
     * Get the .env file path.
     *
     * @return string
     */
    protected function envPath()
    {
        return $this->laravel->basePath('.env');
    }
}