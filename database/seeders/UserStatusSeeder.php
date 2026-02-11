<?php

namespace Database\Seeders;

use App\Models\UserStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserStatus::insert(
            [
                ['id' => 100, 'name' => 'Админ1'],
                ['id' => 200, 'name' => 'Пользователь1'],
                ['id' => 600, 'name' => 'Очень Стремный клиент1']
            ]
        );
    }
}
