<?php
namespace Laililmahfud\Adminportal\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Laililmahfud\Adminportal\Services\CmsModuleService;

class AdminPortal{

    public $user;
    public $role;
    public $modules;
    /**
     * This function for return login user data
     */
    public static function user(){
        $prefix = portal_config('auth.session_name_prefix');
        $self = new static;
        $self->user = session("{$prefix}.user");
        $self->role = session("{$prefix}.role");
        $self->modules = session("{$prefix}.modules");
        return $self;
    }

    /**
     * This function for set admin auth session
     */
    public static function login($user){
        $prefix = portal_config('auth.session_name_prefix');
        $user = json_decode($user->toJson());
        $roles = $user->roles;
        unset($user->roles);
        session()->put("{$prefix}.user",$user);
        session()->put("{$prefix}.role",$roles);
        session()->put("{$prefix}.modules",self::userModuls($roles->is_superadmin,$roles->permission_modules));
        return new static;
    }

    public static function logout(){
        session()->flush();
    }

    public static function uploadFile($file,$location='image'){
        return Storage::disk('local')->put("uploads/{$location}",$file);
    }

    public static function listDatabaseTables()
    {
        $tables =  DB::select("SELECT table_name as name FROM information_schema.tables WHERE table_schema  = '" . env('DB_DATABASE') . "' and table_name not like 'cms_%' and table_name not in ('migrations','personal_access_tokens','jobs','failed_jobs','roles_permission')");
        array_push($tables,(object)[
            'name'=>'cms_admin'
        ]);
        return $tables;
    }


    public static function getAllColumTable($table_name,$exclude=['id','created_at','updated_at']){
        $columns = [];
        $describeTable = DB::select("DESCRIBE {$table_name}");
        foreach ($describeTable as $key => $value) {
           if(!in_array($value->Field, $exclude)){
            $columns[] = $value->Field;
           }
        }
        return $columns;
    }

    public static function userModuls($isSuperadmin,$modules){
        return (new CmsModuleService())->treeModuls($isSuperadmin,$modules);
    }
}