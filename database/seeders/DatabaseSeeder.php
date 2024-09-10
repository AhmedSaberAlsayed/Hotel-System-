<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Room;
use App\Models\Guest;
use App\Models\Staff;
use App\Models\Service;
use App\Models\RoomType;
use App\Models\Department;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Guest::factory(30)->create();
        RoomType::factory(3)->create();
        Department::factory(20)->create();
        Room::factory(50)->create();
        Service::factory(20)->create();
        Staff::factory(100)->create();
    }
}
