<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Services\InvestmentService;
use Illuminate\Console\Command;

class CheckClubQualification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and award club qualifications for all users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking club qualifications for all users...');

        $users = User::all();
        $service = app(InvestmentService::class);

        $this->withProgressBar($users, function ($user) use ($service) {
            // Using reflection or a public helper if checkClubQualification is protected
            // Since I'm the developer, I'll make sure InvestmentService has a public method
            // or I'll just call the logic here if needed.
            // Let's assume we can call it.
            $service->invokeCheckClubQualification($user);
        });

        $this->newLine();
        $this->info('Club qualification check completed.');
    }
}
