<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
class Admin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lấy id của role 'admin'
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');

        // Tạo tài khoản admin
        DB::table('users')->insert([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456789'), // Mật khẩu từ 1-9
            'role_id' => $adminRoleId,
            'remember_token' => null,
        ]);
    }
}
