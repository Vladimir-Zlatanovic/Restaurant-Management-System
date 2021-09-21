<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('role_user')->delete();
        $adminRole = Role::where('ime', 'admin')->first();
        $korisnikRole = Role::where('ime', 'korisnik')->first();
        $korisnici =   [
                [
                    'name' => 'Ilija',
                    'email' => 'ilija@ilija.com',
                    'password' => Hash::make('ilija12345')
        
                ],
                [
                    'name' => 'Petar',
                    'email' => 'petar@petar.com',
                    'password' => Hash::make('petar12345')
        
                ],
                [
                    'name' => 'Milos',
                    'email' => 'milos@milos.com',
                    'password' => Hash::make('milos12345')
        
                ],

            ];
            foreach($korisnici as $podaci){
                $korisnik = User::create($podaci);
                $korisnik->roles()->attach($korisnikRole);
            }   
            $admin = User::create([
            'name' => 'Vladimir',
            'email' => 'vladimir.zlatanovic98@gmail.com',
            'password' => Hash::make('allen.iverson1')

        ]);
        $korisnik = User::create([
            'name' => 'Vlada korisnik',
            'email' => 'vlada@korisnik.com',
            'password' => Hash::make('vlada korisnik'),

        ]);
        $admin->roles()->attach($adminRole);
        $korisnik->roles()->attach($korisnikRole);

    }
}
