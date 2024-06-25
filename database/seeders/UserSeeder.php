<?php

/**
 * Seeder for User Table
 * Created on 25 October 2023
 * Author : Frank Zohim
*/
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         //Data to store
        $data = [
            [
                'username'=>'delanofofe',
                'email'=>'delanofofe@gmail.com',
                'role_id' => 1,
                'phone_number' => "675824349",
                'password' => Hash::make('password'),
                'isVerify' => 1,
                "balance"=>0,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
             [
                'username'=>'frankzohim',
                'email'=>'frankzohim@gmail.com',
                'role_id' => 2,
                'phone_number' => "690394365",
                "balance"=>0,
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'username'=>'franknyawa',
                'email'=>'franknyawa@gmail.com',
                'role_id' => 2,
                'phone_number' => "693374160",
                "balance"=>0,
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

             [
                'username'=>'admin',
                'email'=>'temerprodesign@yahoo.fr',
                'role_id' => 1,
                "balance"=>0,
                'phone_number' => "698825366",
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
              [
                'username'=>'maeva',
                'email'=>'maeve@gmail.com',
                'role_id' => 3,
                "balance"=>3000,
                'phone_number' => "694145298",
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
              [
                'username'=>'francis',
                'email'=>'francis@gmail.com',
                'role_id' => 4,
                "balance"=>5000,
                'phone_number' => "671375860",
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
              [
                'username'=>'henry',
                'email'=>'sheila@gmail.com',
                'role_id' => 4,
                "balance"=>100000,
                'phone_number' => "654011210",
                'password' => Hash::make('password'),
                'isVerify' => 0,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
              [
                'username'=>'anna',
                'email'=>'anna@gmail.com',
                'role_id' => 3,
                "balance"=>1000,
                'phone_number' => "655259632",
                'password' => Hash::make('password'),
                'isVerify' => 1,
                'email_verified_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],

        ];

        //Storing Data
        DB::table('users')->insert($data);
    }
}
