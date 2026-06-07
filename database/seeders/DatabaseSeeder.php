<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Admin;
use App\Models\Admin\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        $user = tap(
            User::create([
                'username' => 'user',
                'name' => 'User',
                'phone' => '01700000000',
                'email' => 'user@gmail.com',
                'password' => Hash::make('12345678')
            ])
        )->markEmailAsVerified();

        $admin = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        $this->call(LaratrustSeeder::class);
        $user->attachRole(Role::whereName('user')->first());
        $admin->attachRole(Role::whereName('admin')->first());

        // Default Category
        Category::insert(
            [
                [
                    'category_name' => 'Snacks',
                    'slug' =>  Str::slug('Snacks')
                ],
                [
                    'category_name' => 'Cookies',
                    'slug' =>  Str::slug('Cookies')
                ]
            ]
        );
    }
}
