<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();

        \App\User::create([
            'name' => 'admin',
            'email' => 'admin@test.com',
            'real_name' => 'admin',
            'password' => bcrypt('admin@123'),
            'user_type' => 1,
            'status' => 1,
            'remark' => '系统管理员',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
