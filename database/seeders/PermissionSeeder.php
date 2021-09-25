<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permissions = [
            ['name' => 'admin' , 'image'=>'admin.jpg'],
            ['name' => 'super_user ' , 'image'=>'super_user.jpg'],
            ['name' => 'client' , 'image'=>'client.jpg'],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
