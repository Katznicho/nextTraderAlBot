<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemberRole;

class MemberRoleSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'role' => 'Admin',
                'permissions' => [
                    'Approve withdrawals', 'Can view member savings', 'Can view member transactions',
                    'Can top up', 'Receive top up notifications', 'Add new members',
                    'Remove members', 'Can withdraw', 'can view member info'
                ]
            ],
            [
                'role' => 'Member',
                'permissions' => [
                    'Can view member savings', 'Can view member transactions',
                    'Can top up', 'Receive top up notifications',
                    'Can withdraw', 'Add new members','Remove members',
                    'can view my savings', 'can view my transactions',
                    'can view member info'
                ]
            ],
            [
                'role' => 'Contributor',
                'permissions' => [
                    'Can view member savings', 'Can view member transactions',
                    'Can top up', 'Receive top up notifications',
                    'Can withdraw', 'Add new members','Remove members',
                    'can view my savings', 'can view my transactions',
                    'can view member info'
                ]
            ],
            [
                'role' => 'FundRaiser',
                'permissions' => [
                    'Can view member savings', 'Can view member transactions',
                    'Can top up', 'Receive top up notifications',
                    'Can withdraw', 'Add new members','Remove members',
                    'can view my savings', 'can view my transactions',
                    'can view member info'
                ]
            ],
            [
                'role' => 'Partner',
                'permissions' => [
                    'Approve withdrawals', 'Can view my savings', 'Can view my transactions',
                    'Can top up', 'Receive top up notifications', 'Add new members',
                ]
            ],
        ];

        foreach ($roles as $role) {
            MemberRole::create([
                'role' => $role['role'],
                'permissions' => $role['permissions']
            ]);
        }
    }
}
