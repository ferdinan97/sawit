<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'role_id' => 1,
                'name' => 'admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('@doesdinggo1'),
            ],
        ];

        foreach ($users as $key => $u) {
            $user = User::create([
                'name' => $u['name'],
                'email' => $u['email'],
                'password' => $u['password'],
                'email_verified_at' => null,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
