<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'slug' => Role::SLUG_ADMIN,
            'name' => 'Administrator'
        ]);

        Role::create([
            'slug' => Role::SLUG_USER,
            'name' => 'User'
        ]);
    }
}
