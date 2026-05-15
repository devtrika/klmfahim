<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder {

    public function run() {
        //DB::table('users')->delete();
        // addfirstuser
        User::create(array(
            'name' => 'trika',
            'mobile' => '01007869353',
            'group_id' => '1',
            'email' => 'admin@admin.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'image' => 'image',
            'type' => 'admin',
            'status' => 'active',
            'seen' => 'yes',
            'remember_token' => Str::random(10),
        ));
        User::create(array(
            'name' => 'moh',
            'mobile' => '04000',
            'group_id' => '1',
            'email' => 'ad@ad.com',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'image' => 'image',
            'type' => 'user',
            'status' => 'active',
            'seen' => 'yes',
            'remember_token' => Str::random(10),
        ));

        \App\Models\Country::create(array(
            'name' => 'مصري'
        ));
        \App\Models\Bank::create(array(
            'name' => 'الاهلي'
        ));
        \App\Models\Category::create(array(
            'name' => 'قسم'
        ));
        \App\Models\Setting::create(array(
            'name' => 'تحكيم',
           
        ));
    }

}
