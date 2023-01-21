<?php

namespace Database\Seeders;

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
        $this->call(UserSeeder::class);
        $this->call(NegaraMasterSeeder::class);
        $this->call(VariableMasterSeeder::class);
        $this->call(VariableDataSeeder::class);
        $this->call(NullHypothesisDataSeeder::class);
    }
}
