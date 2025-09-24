<?php
namespace Laililmahfud\Adminportal\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use function Laravel\Prompts\text;
use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Schema;

class AdminPortalMakeModuleCommand extends Command
{
     /**
      * The name and signature of the console command.
      *
      * @var string
      */
     protected $signature = 'adminportal:module  
                              {--table= : table of module} 
                              {--module= : name of module} 
                              {--url= : url of module whitout admin prefix} 
                              {--icon= : icon of module} 
                              {--controller= : name of controller}';

     /**
      * The console command description.
      *
      * @var string
      */
     protected $description = 'Admin Portal generate new module';

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
          $tableName = $this->option('table');
          if($tableName){
               $tableExists = Schema::hasTable($tableName);
               if (!$tableExists) {
                    error("The table '$tableName' does not exist. Please try again.");
               }
          }else{
               while (true) {
                    $tableName = text(
                         label: 'Table ?',
                         required: true
                    );

                    $tableExists = Schema::hasTable($tableName);
                    if (!$tableExists) {
                         error("The table '$tableName' does not exist. Please try again.");
                    }else{
                         break;
                    }
               }
          }
          
          $moduleName = $this->option('module');
          if(!$moduleName){
               $moduleName = text(
                    label: 'Module Name ?',
                    required: true,
                    default: ucwords(str_replace('_', ' ', $tableName)),
               );
          }

          $moduleUrl = $this->option('url');
          if(!$moduleUrl){
               $moduleUrl = text(
                    label: 'Module URL ?',
                    required: true,
                    default: Str::slug($tableName)
               );
          }

          $moduleIcon = $this->option('icon');
          if(!$moduleIcon){
               $moduleIcon = text(
                    label: 'Module Icon ?',
                    required: true,
                    hint: 'User blade tabler icon https://blade-ui-kit.com/blade-icons',
                    default: 'database-plus'
               );
          }

          $modelName = Str::singular(str_replace(' ', '', ucwords(str_replace(["-", "_"], [" ", " "], $tableName))));

          $controllerName = $this->option('controller');
          if(!$controllerName){
               $controllerName = text(
                    label: 'Controller Name ?',
                    required: true,
                    default: "Admin{$modelName}Controller"
               );
          }
          

          $modelName = $this->generateModel($modelName);
          $repository = $this->generateRepository($modelName);
          $resourcesPath = str()->slug($tableName);
          $this->generateController($repository, $moduleName, $moduleUrl, $moduleIcon, $controllerName, $tableName, $resourcesPath);
          $this->generateResource($resourcesPath, $moduleUrl);
     }

     private function generateModel($modelName)
     {
          $modelDir = app_path('Models');
          if (!file_exists($modelDir)) {
               @mkdir($modelDir, 0755);
          }
          if (!file_exists(app_path("Models/{$modelName}.php"))) {
               $modelTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/model.stub');

               //assign all variable to model template
               $modelTemplate = str_replace('[modelName]', $modelName, $modelTemplate);
               file_put_contents($modelDir . '/' . $modelName . '.php', $modelTemplate);
          }
          return $modelName;
     }

     private function generateRepository($modelName)
     {

          $repositoryName = $modelName . "Repository";
          $repositoryDir = app_path('Repository');
          if (!file_exists($repositoryDir)) {
               @mkdir($repositoryDir, 0755);
          }

          if (!file_exists(app_path("Repository/{$repositoryName}.php"))) {
               $repositoryTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/repository.stub');
               $repositoryTemplate = str_replace('[repositoryName]', $repositoryName, $repositoryTemplate);
               $repositoryTemplate = str_replace('[modelName]', $modelName, $repositoryTemplate);

               file_put_contents($repositoryDir . '/' . $repositoryName . '.php', $repositoryTemplate);
          }
          return $repositoryName;

     }

     private function generateController($repository, $moduleName, $moduleUrl, $moduleIcon, $controllerName, $tableName, $resourcesPath)
     {
          $policy = str()->slug($tableName);

          $controllerDir = app_path('Http/Controllers/Admin');
          if (!file_exists($controllerDir)) {
               @mkdir($controllerDir, 0755);
          }

          if (!file_exists("{$controllerDir}/{$controllerName}.php")) {
               $template = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/controller.stub');
               $template = str_replace('[controllerName]', $controllerName, $template);
               $template = str_replace('[repositoryName]', $repository, $template);
               $template = str_replace('[policy]', $policy, $template);
               $template = str_replace('[icon]', $moduleIcon, $template);
               $template = str_replace('[url]', $moduleUrl, $template);
               $template = str_replace('[title]', $moduleName, $template);
               $template = str_replace('[resources]', $resourcesPath, $template);

               file_put_contents($controllerDir . '/' . $controllerName . '.php', $template);
          }
     }

     private function generateResource($resourcePath, $moduleUrl)
     {
          $resourcePath = resource_path("views/admin/{$resourcePath}");
          if (!file_exists($resourcePath)) {
               if (!file_exists(resource_path('views/admin'))) {
                    @mkdir(resource_path('views/admin'), 0755);
               }
               @mkdir($resourcePath, 0755);
          }

          if (!file_exists("{$resourcePath}/index.blade.php")) {
               $indexTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/index.stub');
               $indexTemplate = str_replace('[url]', $moduleUrl, $indexTemplate);
               file_put_contents($resourcePath . '/index.blade.php', $indexTemplate);
          }

          if (!file_exists("{$resourcePath}/create.blade.php")) {
               $createTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/create.stub');
               $createTemplate = str_replace('[url]', $moduleUrl, $createTemplate);
               file_put_contents($resourcePath . '/create.blade.php', $createTemplate);
          }

          if (!file_exists("{$resourcePath}/update.blade.php")) {
               $updateTemplate = file_get_contents(__DIR__ . '/../../../resources/stubs/Module/update.stub');
               $updateTemplate = str_replace('[url]', $moduleUrl, $updateTemplate);
               file_put_contents($resourcePath . '/update.blade.php', $updateTemplate);
          }
     }
}
