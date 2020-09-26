<?php

use App\Model\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ["Admin", "Approver", "User"];
        foreach ($roles as $key => $role) {
            $create = new Role();
            $create->name = $role;
            $create->save();
        }
    }
}
