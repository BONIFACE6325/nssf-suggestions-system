<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Region;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin user (HQ can see all regions)
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@nssf.local',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'region_id' => null,
        ]);

        // Example manager (linked to Dodoma region)
        $dodoma = Region::where('name', 'Dodoma')->first();

        if ($dodoma) {
            User::create([
                'name' => 'Dodoma Manager',
                'email' => 'dodoma.manager@nssf.local',
                'password' => Hash::make('password123'),
                'role' => 'manager',
                'region_id' => $dodoma->id,
            ]);
        }
    }
}
