<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DashboardController;

class SendPendingReviewNotifications extends Command
{
    protected $signature = 'notifications:send-pending-reviews';
    protected $description = 'Send notifications for pending CSR reviews';

    public function handle()
    {
        $controller = new DashboardController();
        $result = $controller->sendPendingReviewNotifications();
        
        $this->info("Sent {$result['count']} notifications successfully.");
        
        return Command::SUCCESS;
    }
}
