<?php

use App\Enums\UserRolesEnum;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    private $defaultPermissions = [
        'administrator' => [
            'web',
            // user
            'user.index',
            'user.create',
            'user.store',
            'user.show',
            'user.edit',
            'user.update',
            'user.destroy',
            // permissions
            'role.index',
            'role.edit',
            'role.update',
            // permissions
            'permission.index',
            'permission.edit',
            'permission.update',
        ],
        'moderator' => [
            'user.show',
        ],
        'user' => [
            'user.show',
        ],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = UserRolesEnum::revArray();
        foreach ($roles as $key => $role) {
            $roleId = DB::table('roles')->insertGetId([
                'name' => $key,
                'guard_name' => 'web',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
            if ($this->defaultPermissions[$key]) {
                collect($this->defaultPermissions[$key])->each(function ($permission) use ($roleId) {
                    if (!$permissionId = DB::table('permissions')->where('name', '=', $permission)->value('id')) {
                        $permissionId = DB::table('permissions')->insertGetId([
                            'name' => $permission,
                            'guard_name' => 'web',
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);
                    }
                    DB::table('role_has_permissions')->insert([
                        'permission_id' => $permissionId,
                        'role_id' => $roleId,
                    ]);
                });
            } else {
                DB::table('role_has_permissions')->insert([
                    'permission_id' => DB::table('permissions')
                        ->where('name', '=', 'web')
                        ->where('guard_name', '=', 'web')
                        ->value('id'),
                    'role_id' => $roleId,
                ]);
            }
        }
        app()['cache']->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $roles = UserRolesEnum::revArray();
        foreach ($roles as $key => $role) {
            $role = DB::table('roles')->where('name', $key)->where('guard_name', 'web')->first();
            DB::table('role_has_permissions')
                ->where('role_id', $role->id)
                ->delete();
            DB::table('roles')->where('id', $role->id)->delete();
        }

        app()['cache']->forget(config('permission.cache.key'));
    }
};
