<?php

namespace App\Console\Commands;

use App\Enums\UserRolesEnum;
use App\Models\User;
use App\Settings\GeneralSettings;
use Illuminate\Console\Command;

class GenerateStartedUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-started-users-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = [
            [
                'first_name' => 'Administrator',
                'last_name' => 'User',
                'email' => 'admin@example.com',
                'role' => UserRolesEnum::ADMINISTRATOR->value,
                'password' => bcrypt('password'),
            ], [
                'first_name' => 'Moderator',
                'last_name' => 'User',
                'email' => 'moderator@example.com',
                'role' => UserRolesEnum::MODERATOR->value,
                'password' => bcrypt('password'),
            ], [
                'first_name' => 'User',
                'last_name' => 'User',
                'email' => 'user@example.com',
                'role' => UserRolesEnum::USER->value,
                'password' => bcrypt('password'),
            ]
        ];

        foreach ($users as $user) {
            $role = $user['role'];
            unset($user['role']);
            $user = User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
            $user->markEmailAsVerified();
            $user->assignRole($role);
        }

        $this->info('Users created successfully');
    }
}
