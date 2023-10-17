<?php

namespace App\Console\Commands;

use App\Modules\Admins\Models\AdminSetting;
use App\Modules\Admins\Models\Admin;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

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
        $name = $this->ask('Admin Name');
        $email = $this->ask('Email');
        $password = $this->secret('Password');

        $admin = Admin::firstOrCreate(['email' => $email],[
            'name' => $name,
            'email' => $email,
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make($password),
        ]);

        AdminSetting::create([
            'admin_id' => $admin->id,
            'dark_mode' => 0
        ]);

        $this->info("Admin has been created");
    }
}
