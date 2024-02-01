<?php
namespace Laililmahfud\Adminportal\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

trait ActionsService
{
     public function store(Request $request)
     {
          return $this->findAction('Create')->handle($request);
     }

     public function update(Request $request, $uuid)
     {
          return $this->findAction('Update')->handle($request, $uuid);
     }


     public function deleteByUuid($uuid)
     {
          return $this->model::where('uuid', $uuid)->first()->delete();
     }
     
     private function findAction($action): mixed
     {
          $actionFolder = $this->action;
          $actionFolder = str_replace('/', '\\', $actionFolder);
          $model = explode('\\', $this->model);
          $model = end($model);
          return App::make("App\\Actions\\$actionFolder\\{$action}$model");
     }
}