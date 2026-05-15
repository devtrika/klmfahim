<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        //
        \DB::table('groups')->insert([
            'id' => '1',
            'name' => 'الإدارة العليا'
        ]);
    }

}
