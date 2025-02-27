<?php

namespace Laililmahfud\Adminportal\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Laililmahfud\Adminportal\Models\CmsRolePermission;

class AdminCmsRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $haveSuperadminPermission = CmsRolePermission::where('is_superadmin', true)->first();
        if (!$haveSuperadminPermission) {
            $adminportalPermission = [
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Superadmin',
                    'alias' => 'superadmin',
                    'is_superadmin' => true,
                    'created_at' => now(),
                ],
                [
                    'uuid' => Str::uuid(),
                    'name' => 'Team Support',
                    'alias' => 'team-support',
                    'is_superadmin' => false,
                    'created_at' => now(),
                ]
            ];
            CmsRolePermission::insert($adminportalPermission);
        }
    }
}
