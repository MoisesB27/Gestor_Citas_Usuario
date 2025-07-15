<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{

    public function run(): void
    {
        $User = new User();
        $User->name = 'Moises';
        $User->username = 'moisesbatista';
        $User->email = 'moisesbatista@gmail.com';
        $User->password = Hash::make('12345678');
        $User->save();
    }
}
