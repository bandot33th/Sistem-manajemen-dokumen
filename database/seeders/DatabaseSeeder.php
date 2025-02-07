<?php

namespace Database\Seeders;

use App\Livewire\PassDocs;
use App\Models\CategoryMasterList;
use App\Models\Document;
use App\Models\Folder;
use App\Models\MasterList;
use App\Models\PasswordDoc;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::factory()->create([ //keperluan bikin banyak
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'department' => 'Engineering',
        ]);

        $admin = Role::create(['name' => 'Admin']);
        $design = Role::create(['name' => 'Design']);
        $workshop = Role::create(['name' => 'workshop']);
        $maintenance = Role::create(['name' => 'Maintenance']);
        $users->assignRole($admin);

        $permission_workshop = permission::create(['name' => 'Workshop']);
        $permission_manual = permission::create(['name' => 'Manual_book']);
        $permission_standard = permission::create(['name' => 'Standard']);
        $permission_Design = permission::create(['name' => 'Design']);
        $permission_maintenance = permission::create(['name' => 'Maintenance']);
        $permission_Drawing = permission::create(['name' => 'Drawing']);

        $design->givePermissionTo([$permission_Design, $permission_manual, $permission_standard, $permission_Drawing, $permission_workshop]);
        $workshop->givePermissionTo([$permission_Drawing, $permission_manual, $permission_standard, $permission_workshop]);
        $maintenance->givePermissionTo([$permission_Drawing, $permission_manual, $permission_standard, $permission_maintenance]);

        $folder = Folder::create([
            'name' => 'Drawing',
            'permission_name' => 'Drawing',
        ]);
        $folder = Folder::create([
            'name' => 'Maintenance',
            'permission_name' => 'Maintenance',
        ]);
        $folder = Folder::create([
            'name' => 'Design',
            'permission_name' => 'Design',
        ]);
        $folder = Folder::create([
            'name' => 'Manual_book',
            'permission_name' => 'Manual_book',
        ]);
        $folder = Folder::create([
            'name' => 'Workshop',
            'permission_name' => 'Workshop',
        ]);
        $folder = Folder::create([
            'name' => 'Standard',
            'permission_name' => 'Standard',
        ]);
        // $folders = ['Drawing', 'Manual Book', 'Standard', 'Design', 'Workshop', 'Maintenance'];

        // foreach ($folders as $folder) {
        //     $folder = Folder::create([
        //         'name' => $folder,
        //         'permission_name' => $folder,
        //     ]);
        // }
        $password = PasswordDoc::create([
            'password' => 'engineer',
        ]);

        // $category = CategoryMasterList::create([
        //     'name' => 'Mechanical',
        // ]);
        // $category = CategoryMasterList::create([
        //     'name' => 'Electrical',
        // ]);
        // $category = CategoryMasterList::create([
        //     'name' => 'Civil',
        // ]);
        // $category = CategoryMasterList::create([
        //     'name' => 'Utility',
        // ]);
    }
}
