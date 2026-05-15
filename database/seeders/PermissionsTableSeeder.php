<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'admins']
        );

        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'contact']
        );

        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'groups']
        );

        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'notifications']
        );
        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'pages']
        );
        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'site']
        );
        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'slider']
        );
        \DB::table('permissions')->insert(
                ['group_id' => '1', 'permission' => 'users']
        );

    }

}
