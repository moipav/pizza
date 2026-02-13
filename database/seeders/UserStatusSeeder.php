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
                ['id' => 1, 'name' => 'Новый пользователь'],
                ['id' => 2, 'name' => 'Активный'],
                ['id' => 6, 'name' => 'Заблокированный'],
            ]
        );
    }
}
