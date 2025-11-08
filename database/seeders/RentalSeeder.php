<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RentalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        $landlords = User::where('role', 'landlord')->pluck('id');
        if ($landlords->isEmpty()) {
            $landlords = collect([
                User::create([
                    'name' => 'John Landlord',
                    'email' => 'john.landlord@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'landlord',
                ])->id,
                User::create([
                    'name' => 'Sarah Landlord',
                    'email' => 'sarah.landlord@example.com',
                    'password' => bcrypt('password'),
                    'role' => 'landlord',
                ])->id,
            ]);
        }

        $data = [
            [
                'title' => 'Modern Studio Apartment',
                'price' => 450.00,
                'description' => 'Fully furnished studio near the university.',
                'location' => 'Debrecen',
                'landlord_id' => $landlords->random(),
                'status' => 'active',
                'image_path' => 'images/rentals/studio1.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Spacious 2-Bedroom Flat',
                'price' => 750.00,
                'description' => 'Large flat with balcony and good sunlight.',
                'location' => 'Budapest',
                'landlord_id' => $landlords->random(),
                'status' => 'inactive',
                'image_path' => 'images/rentals/flat2.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Affordable Shared Room',
                'price' => 250.00,
                'description' => 'Ideal for students, close to bus station.',
                'location' => 'Miskolc',
                'landlord_id' => $landlords->random(),
                'status' => 'available',
                'image_path' => 'images/rentals/shared3.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Luxury Loft Downtown',
                'price' => 980.00,
                'description' => 'Newly renovated loft with modern design.',
                'location' => 'Szeged',
                'landlord_id' => $landlords->random(),
                'status' => 'rented',
                'image_path' => 'images/rentals/loft4.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Small Single Apartment',
                'price' => 350.00,
                'description' => 'Perfect for single tenants, quiet neighborhood.',
                'location' => 'Pecs',
                'landlord_id' => $landlords->random(),
                'status' => 'active',
                'image_path' => 'images/rentals/single5.jpg',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('rentals')->insert($data);
    }
}
