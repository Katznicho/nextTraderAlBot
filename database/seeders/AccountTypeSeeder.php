<?php

namespace Database\Seeders;

use App\Models\AccountType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountTypeSeeder extends Seeder
{
    public function run()
    {
        $accountTypes = [
            ['name' => 'Partner', 'description' => 'Business partners', 'status' => 'active'],
            ['name' => 'Personal', 'description' => 'Individual accounts', 'status' => 'active'],
            ['name' => 'Group', 'description' => 'Group accounts', 'status' => 'active'],
            ['name' => 'Fundraiser', 'description' => 'Accounts for fundraising', 'status' => 'active'],
        ];

        foreach ($accountTypes as $type) {
            AccountType::create($type);
        }
    }
}
