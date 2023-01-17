<?php

namespace App\Console\Commands;

use App\Mail\SubscriptionAlertMail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class BeforePlanExpired extends Command
{
    protected $signature = 'plan:before';

    protected $description = 'Send alert before plan expire';

    public function handle()
    {
        $cron = get_option('cron_option', true);
        $willExpire = today()->addDays($cron->first_expire_days)->format('Y-m-d');

        $firstAlertUsers = User::whereWillExpire($willExpire)->get();
        $this->sendEmail($firstAlertUsers);

        $willExpire = today()->addDays($cron->second_expire_days)->format('Y-m-d');
        $secondAlertUsers =  User::whereWillExpire($willExpire)->get();
        $this->sendEmail($secondAlertUsers);
    }

    private function sendEmail($users)
    {
        foreach ($users as $user) {
            if (config('system.queue.mail')){
                Mail::to($user)->queue(new SubscriptionAlertMail($user));
            } else{
                Mail::to($user)->send(new SubscriptionAlertMail($user));
            }
        }
    }
}
