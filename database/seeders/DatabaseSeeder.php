<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\TipoCliente;
use App\Models\UnidadMedida;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $rol = new Role();
        $rol->name = "Admin";
        $rol->guard_name = "web";
        $rol->save();

        $user  = new User();
        $user->name = "Alexander";
        $user->email = "alexlo@gmail.com";
        $user->password = '$2y$10$bR76GsquMIXLpsoD0JoPfueBUgiV3uYfNFQNWy14zZ3h5O9JRJJ2C';
        $user->save();

        $user->assignRole($rol);

        Role::create([
            'name' => 'Usuario',
            'guard_name' => 'web'
,
        ]);
        UnidadMedida::create(['nombre'=>'CAJA','abreviatura'=>'CAJ.','codigo'=>'BX']);
        UnidadMedida::create(['nombre'=>'PAQUETE','abreviatura'=>'PAQ.','codigo'=>'PK']);
        UnidadMedida::create(['nombre'=>'UNIDAD','abreviatura'=>'UNI.','codigo'=>'NIU']);
        TipoCliente::create(['nombre'=>'PÚBLICO']);
        TipoCliente::create(['nombre'=>'POR MAYOR']);
    }
}
