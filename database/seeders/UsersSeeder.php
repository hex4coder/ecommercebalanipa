<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaultUser = new User();
        $defaultUser->name = "Darwis";
        $defaultUser->email = "darwis@smknbalanipa.sch.id";
        $defaultUser->role = 0; // administrator
        $defaultUser->password = bcrypt("12345678");
        $defaultUser->save();
    }
}
