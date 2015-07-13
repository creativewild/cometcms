<?php

use Illuminate\Database\Seeder;
use App\User, App\Role, App\Permission;

class UsersTableSeeder extends Seeder {

    public function run()
    {
        $faker = Faker\Factory::create();

        $roleAdmins = new Role();
        $roleAdmins->name = 'admin';
        $roleAdmins->display_name = 'Admins';
        $roleAdmins->description = 'All site administrators';
        $roleAdmins->save();

        $roleUsers = new Role();
        $roleUsers->name = 'user';
        $roleUsers->display_name = 'Users';
        $roleUsers->description = 'All registered users';
        $roleUsers->save();

        $roleModerators = new Role();
        $roleModerators->name = 'mod';
        $roleModerators->display_name = 'Moderators';
        $roleModerators->description = 'All site mods';
        $roleModerators->save();

        $roleContent = new Role();
        $roleContent->name = 'content';
        $roleContent->display_name = 'Content managers';
        $roleContent->description = 'Site content managers';
        $roleContent->save();

        // Match permissions
        $createMatch = new Permission();
        $createMatch->name = 'create-match';
        $createMatch->display_name = 'Create Matches';
        $createMatch->description  = 'Role can create matches';
        $createMatch->save();
        $editMatch = new Permission();
        $editMatch->name = 'edit-match';
        $editMatch->display_name = 'Edit Matches';
        $editMatch->description  = 'Role can edit matches';
        $editMatch->save();
        $deleteMatch = new Permission();
        $deleteMatch->name = 'delete-match';
        $deleteMatch->display_name = 'Delete Matches';
        $deleteMatch->description  = 'Role can delete matches';
        $deleteMatch->save();

        $createTeam = new Permission();
        $createTeam->name = 'create-team';
        $createTeam->display_name = 'Create Teams';
        $createTeam->description  = 'Role can create teams';
        $createTeam->save();
        $editTeam = new Permission();
        $editTeam->name = 'edit-team';
        $editTeam->display_name = 'Edit Teams';
        $editTeam->description  = 'Role can edit teams';
        $editTeam->save();
        $deleteTeam = new Permission();
        $deleteTeam->name = 'delete-team';
        $deleteTeam->display_name = 'Delete Teams';
        $deleteTeam->description  = 'Role can delete teams';
        $deleteTeam->save();

        $createOpponent = new Permission();
        $createOpponent->name = 'create-opponent';
        $createOpponent->display_name = 'Create Opponents';
        $createOpponent->description  = 'Role can create opponents';
        $createOpponent->save();
        $editOpponent = new Permission();
        $editOpponent->name = 'edit-opponent';
        $editOpponent->display_name = 'Edit Opponents';
        $editOpponent->description  = 'Role can edit opponents';
        $editOpponent->save();
        $deleteOpponent = new Permission();
        $deleteOpponent->name = 'delete-opponent';
        $deleteOpponent->display_name = 'Delete Opponents';
        $deleteOpponent->description  = 'Role can delete opponents';
        $deleteOpponent->save();

        $createUser = new Permission();
        $createUser->name = 'create-user';
        $createUser->display_name = 'Create Users';
        $createUser->description  = 'Role can create Users';
        $createUser->save();
        $editUser = new Permission();
        $editUser->name = 'edit-user';
        $editUser->display_name = 'Edit Users';
        $editUser->description  = 'Role can edit Users';
        $editUser->save();
        $deleteUser = new Permission();
        $deleteUser->name = 'delete-user';
        $deleteUser->display_name = 'Delete Users';
        $deleteUser->description  = 'Role can delete users';
        $deleteUser->save();

        $roleAdmins->attachPermissions([$createMatch, $editMatch, $deleteMatch, $createTeam, $editTeam, $deleteTeam, $createOpponent, $editOpponent, $deleteOpponent,
            $createUser, $editUser, $deleteUser]);
        $roleModerators->attachPermissions([$createMatch, $editMatch, $deleteMatch]);
        $roleContent->attachPermissions([$createMatch, $editMatch, $createTeam, $editTeam]);

        User::create([
            'name' => 'Karlo',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123')
        ])->attachRoles([$roleAdmins, $roleUsers]);

        for ($i=0; $i < 54; $i++) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => Hash::make('demo123')
            ])->attachRole($roleUsers);
        }
    }

}