<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class ChangeRoleCommand extends Command
{
    protected $signature = 'user:role {email} {role}';

    protected $description = 'Change role';

    public function handle()
    {
        $email = $this->argument('email');
        $role = $this->argument('role');

        if (!$user = User::where('email', $email)->first()) {
            $this->error('Undefined user with email ' . $email);
            return false;
        }

        try {
            $user->changeRole($role);
        } catch (\InvalidArgumentException|\DomainException $e) {
            $this->error($e->getMessage());
            return false;
        }

        $this->info('Role is changed');
        return true;
    }
}
