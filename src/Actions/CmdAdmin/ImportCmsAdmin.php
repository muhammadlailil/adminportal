<?php
namespace Laililmahfud\Adminportal\Actions\CmdAdmin;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Models\CmsRolePermission;


class ImportCmsAdmin
{
     public function handle(UploadedFile $file)
     {
          $file = Storage::disk('local')->putFileAs("import", $file, Str::random(50) . '.csv');
          $filePath = Storage::disk('local')->path($file);

          $handle = fopen($filePath, 'r');
          fgets($handle);

          $chunks = [];
          $chunkSize = 500;
          $now = now()->format('Y-m-d H:i:s');

          $permissions = CmsRolePermission::select(['alias','id'])->get();

          while (($line = fgets($handle)) !== false) {
               $row = str_getcsv($line,";");
               
               $permission = $permissions->where('alias',$row[2])->first();
               if(!$permission){
                    continue;
               }

               $chunks[] = [
                    'uuid' => DB::raw("uuid()"),
                    'name' => $row[0],
                    'email' => $row[1],
                    'role_permission_id' => $permission->id,
                    'status' => 1,
                    'password' => Hash::make($row[3]),
                    'email_verified_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
               ];

               if (count($chunks) === $chunkSize) {
                    CmsAdmin::insertOrIgnore($chunks);
                    $chunks = [];
               }
          }

          if (!empty($chunks)) {
               CmsAdmin::insertOrIgnore($chunks);
               $chunks = [];
          }
          
          fclose($handle);
          Storage::disk('local')->delete($file);
     }
}