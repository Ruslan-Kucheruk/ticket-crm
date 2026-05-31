<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleAndUserSeeder;
use App\Models\Customer;
use App\Models\Ticket;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleAndUserSeeder::class);

        Customer::factory()
            ->count(20)
            ->create()
            ->each(function ($customer) {
                Ticket::factory()
                    ->count(rand(1, 5))
                    ->create([
                        'customer_id' => $customer->id,
                    ]);
            });
    }
}
