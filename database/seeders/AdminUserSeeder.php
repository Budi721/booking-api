<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'phone' => '085813651324',
            'password' => bcrypt('root'),
            'role_id' => 1, // Administrator
        ]);
    }
}
