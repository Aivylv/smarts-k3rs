<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // APAR
            'apar.view',
            'apar.create',
            'apar.edit',
            'apar.delete',
            'apar.export',
            'apar.import',
            
            // Inspeksi
            'inspeksi.view',
            'inspeksi.create',
            'inspeksi.edit',
            'inspeksi.delete',
            
            // Maintenance
            'maintenance.view',
            'maintenance.create',
            'maintenance.edit',
            'maintenance.complete',
            'maintenance.approve',
            
            // Lokasi
            'lokasi.view',
            'lokasi.create',
            'lokasi.edit',
            'lokasi.delete',
            
            // Vendor
            'vendor.view',
            'vendor.create',
            'vendor.edit',
            'vendor.delete',
            
            // Laporan
            'laporan.view',
            'laporan.create',
            'laporan.export',
            
            // User Management
            'user.view',
            'user.create',
            'user.edit',
            'user.delete',
            
            // Settings
            'settings.view',
            'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions(Permission::all());

        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor']);
        $supervisorRole->syncPermissions([
            'apar.view', 'apar.create', 'apar.edit', 'apar.export',
            'inspeksi.view', 'inspeksi.create', 'inspeksi.edit',
            'maintenance.view', 'maintenance.create', 'maintenance.edit', 'maintenance.approve',
            'lokasi.view', 'lokasi.create', 'lokasi.edit',
            'vendor.view',
            'laporan.view', 'laporan.create', 'laporan.export',
            'user.view',
        ]);

        $petugasRole = Role::firstOrCreate(['name' => 'petugas']);
        $petugasRole->syncPermissions([
            'apar.view',
            'inspeksi.view', 'inspeksi.create',
            'maintenance.view', 'maintenance.create',
            'lokasi.view',
            'laporan.view',
        ]);

        $teknisiRole = Role::firstOrCreate(['name' => 'teknisi']);
        $teknisiRole->syncPermissions([
            'apar.view',
            'maintenance.view', 'maintenance.complete',
        ]);

        $auditorRole = Role::firstOrCreate(['name' => 'auditor']);
        $auditorRole->syncPermissions([
            'apar.view', 'apar.export',
            'inspeksi.view',
            'maintenance.view',
            'lokasi.view',
            'vendor.view',
            'laporan.view', 'laporan.export',
        ]);

        // Create default admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@smartk3.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'department' => 'K3RS',
                'is_active' => true,
            ]
        );
        $admin->syncRoles(['admin']);

        // Create demo users
        $supervisor = User::firstOrCreate(
            ['email' => 'supervisor@smartk3.com'],
            [
                'name' => 'Supervisor K3',
                'password' => Hash::make('password'),
                'phone' => '081234567891',
                'department' => 'K3RS',
                'is_active' => true,
            ]
        );
        $supervisor->syncRoles(['supervisor']);

        $petugas = User::firstOrCreate(
            ['email' => 'petugas@smartk3.com'],
            [
                'name' => 'Petugas K3',
                'password' => Hash::make('password'),
                'phone' => '081234567892',
                'department' => 'K3RS',
                'is_active' => true,
            ]
        );
        $petugas->syncRoles(['petugas']);

        $teknisi = User::firstOrCreate(
            ['email' => 'teknisi@smartk3.com'],
            [
                'name' => 'Teknisi APAR',
                'password' => Hash::make('password'),
                'phone' => '081234567893',
                'department' => 'Maintenance',
                'is_active' => true,
            ]
        );
        $teknisi->syncRoles(['teknisi']);
    }
}
