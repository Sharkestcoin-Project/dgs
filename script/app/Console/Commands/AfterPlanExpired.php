<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionExpiredMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class AfterPlanExpired extends Command
{
    protected $signature = 'plan:after';

    protected $description = 'Send Email after plan expired';

    public function handle()
    {
        $expiredDate = today()->addDays(-1)->format('Y-m-d');
        $expiredUsers = User::whereWillExpire($expiredDate)->get();

        foreach ($expiredUsers as $user) {
            if (config('system.queue.mail')){
                Mail::to($user)->queue(new SubscriptionExpiredMail($user));
            } else{
                Mail::to($user)->send(new SubscriptionExpiredMail($user));
            }
        }
    }
}
