<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        Role::firstOrCreate(['key' => 'photographer'], ['name' => 'カメラマン']);
        Role::firstOrCreate(['key' => 'model'], ['name' => 'モデル']);
    }
}
