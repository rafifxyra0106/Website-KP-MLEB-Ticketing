<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class BuatAdmin extends Command
{
    protected $signature   = 'mleb:buat-admin';
    protected $description = 'Membuat akun admin default MLEB';

    public function handle(): void
    {
        $this->info('');
        $this->info('  ⚡  Setup Akun MLEB');
        $this->info('  ═══════════════════════');

        User::updateOrCreate(['email' => 'admin@mleb.id'], [
            'name'     => 'Administrator MLEB',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
            'phone'    => '02187793000',
        ]);

        $this->info('  ✅ Admin : admin@mleb.id / admin123');

        User::updateOrCreate(['email' => 'budi@example.com'], [
            'name'     => 'Budi Santoso',
            'password' => Hash::make('password'),
            'role'     => 'pengunjung',
            'phone'    => '081234567890',
        ]);

        $this->info('  ✅ Demo  : budi@example.com / password');
        $this->info('');
        $this->warn('  ⚠  Segera ganti password admin setelah login!');
        $this->info('');
    }
}
