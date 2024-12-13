<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $universities = [
            ['title' => 'University of Colombo', 'address' => 'Colombo, Sri Lanka'],
            ['title' => 'University of Peradeniya', 'address' => 'Peradeniya, Sri Lanka'],
            ['title' => 'University of Moratuwa', 'address' => 'Moratuwa, Sri Lanka'],
            ['title' => 'University of Sri Jayewardenepura', 'address' => 'Nugegoda, Sri Lanka'],
            ['title' => 'University of Kelaniya', 'address' => 'Kelaniya, Sri Lanka'],
            ['title' => 'University of Ruhuna', 'address' => 'Matara, Sri Lanka'],
            ['title' => 'University of Jaffna', 'address' => 'Jaffna, Sri Lanka'],
            ['title' => 'Eastern University, Sri Lanka', 'address' => 'Chenkalady, Sri Lanka'],
            ['title' => 'South Eastern University of Sri Lanka', 'address' => 'Oluvil, Sri Lanka'],
            ['title' => 'Wayamba University of Sri Lanka', 'address' => 'Makandura, Sri Lanka']
        ];
        // Insert data into the 'universities' table
        DB::table('universities')->insert($universities);
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            [
                'full_name' => 'Akesh Samuditha',
                'username' => 'Akesh',
                'university_id' => 1,
                'uni_reg_no' => '200199T',
                'email' => 'akesh.20@cse.mrt.ac.lk',
                'password' => Hash::make('password'),
            ],
            [
                'full_name' => 'Tharusha Bandaranayake',
                'username' => 'Tharusha',
                'university_id' => 1,
                'uni_reg_no' => '200073D',
                'email' => 'tharusha.20@cse.mrt.ac.lk',
                'password' => Hash::make('password'),
            ]
        ]);
    }
}
