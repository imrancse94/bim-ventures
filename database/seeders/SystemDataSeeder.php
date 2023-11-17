<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SystemDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Dummy User Insert            
        User::create([
                'name'=>'Abdur Rahman',
                'phone'=>'0122546992',
                'password'=>Hash::make('123456'),
                'email'=>'test@admin.com',
                'user_type'=>1, // 1 for admin
            ]);

        User::create([
                'name'=>'Solaiman Kader',
                'phone'=>'0122546992',
                'email'=>'solaiman@customer.com',
                'password'=>Hash::make('123456'),
                'user_type'=>2, // 1 for customer
            ]);        
        
        
        User::create([
            'name'=>'Ibrahim Khalil',
            'phone'=>'0122546992',
            'email'=>'ibrahim@customer.com',
            'password'=>Hash::make('123456'),
            'user_type'=>2, // 1 for customer
        ]);        
        
        
    }
}
