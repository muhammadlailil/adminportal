<?php
namespace Laililmahfud\Adminportal\Database\seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Laililmahfud\Adminportal\Models\CmsAdmin;
use Laililmahfud\Adminportal\Models\RolesPermission;

class AdminPortalSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        self::seedCmsUser();
    }

    private static function seedCmsUser()
    {
        $privileges = RolesPermission::where('is_superadmin', 1)->first();
        if (!$privileges) {
            $privileges = RolesPermission::create([
                'name' => 'Super Admin',
                'is_superadmin' => 1,
            ]);
        }
        if (!CmsAdmin::where('email', 'portal@admin.com')->first()) {
            CmsAdmin::create([
                'name' => 'Lailil Mahfud',
                'email' => 'portal@admin.com',
                'password' => Hash::make('P@ssw0rd'),
                'role_permission_id' => $privileges->id,
                'status' => 1,
                'profile' => 'adminportal/img/avatar.jpg',
            ]);
        }
    }
}
