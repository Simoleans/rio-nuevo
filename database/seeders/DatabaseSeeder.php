<?php

namespace Database\Seeders;

use App\Models\Machine;
use App\Models\Productor;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->has(Machine::factory()->count(25), 'machines')->has(Productor::factory()->count(25), 'productors')->create();
        \App\Models\TipoCultivo::factory()->count(25)->create();
        \App\Models\Campo::factory()->count(25)->create();
        \App\Models\Variedad::factory()->count(10)->create();
    }
}
