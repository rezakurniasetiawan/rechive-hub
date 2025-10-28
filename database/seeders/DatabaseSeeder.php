<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User Seeder
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('password'),
            ],
        ];

        foreach ($users as $data) {
            User::factory()->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
        }
        // Finance Type Seeder
        $financeTypes = [
            [
                'name' => 'income',
                'label' => 'Income (Pemasukan)',
            ],
            [
                'name' => 'expense',
                'label' => 'Expense (Pengeluaran)',
            ],
            [
                'name' => 'transfer',
                'label' => 'Transfer (Antar Akun)',
            ],
            [
                'name' => 'withdrawal',
                'label' => 'Withdrawal (Ambil Tunai dari Bank)',
            ],
            [
                'name' => 'deposit',
                'label' => 'Deposit (Simpan Tunai ke Bank)',
            ],
        ];

        foreach ($financeTypes as $type) {
            \App\Models\Finance\FinanceType::firstOrCreate(
                ['name' => $type['name']],
                ['label' => $type['label']]
            );
        }
    }
}
