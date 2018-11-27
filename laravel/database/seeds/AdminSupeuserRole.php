<?php

use Illuminate\Database\Seeder;

class AdminSupeuserRole extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = \App\Models\Admin\AdminRole::create(
            [
                'accessLevel' => 9,
                'accessMap' => ['all' => ['r','w','c','d']]
            ]
        );

        $defaultAdminUser = \App\Models\Admin\AdminUser::where('login','root')->first();

        \DB::table('admin_user_roles')->insert([
            'adminUserId' => $defaultAdminUser->adminUserId,
            'adminRoleId' => $superAdminRole->adminRoleId,
            'validTill' => '2099-01-01',
            'created_at' => 'now()',
            'updated_at' => 'now()'
        ]);
    }
}
