<?php

namespace App\Http\Controllers;

use App\Mail\SubscriptionAlertMail;
use App\Mail\SubscriptionExpiredMail;
use App\Mail\UserPlanExpireAfterMail;
use App\Mail\UserPlanExpireBeforeMail;
use App\Models\TemporaryFile;
use App\Models\User;
use App\Models\UserPlanOrder;
use Illuminate\Http\Request;
use Mail;

class CronController extends Controller
{
    public function run()
    {
        $this->afterPlanExpire();
        $this->beforePlanExpire();

        $this->afterUserPlanExpire();
        $this->beforeUserPlanExpire();

        $this->deleteTemporaryFiles();

        return true;
    }

    private function afterPlanExpire()
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

    private function beforePlanExpire()
    {
        $willExpire = today()->addDays(7)->format('Y-m-d');
        $firstAlertUsers = User::whereWillExpire($willExpire)->get();
        $this->sendEmail($firstAlertUsers);

        $willExpire = today()->addDays(3)->format('Y-m-d');
        $secondAlertUsers =  User::whereWillExpire($willExpire)->get();
        $this->sendEmail($secondAlertUsers);

        $willExpire = today()->addDays(1)->format('Y-m-d');
        $thirdAlertUsers =  User::whereWillExpire($willExpire)->get();
        $this->sendEmail($thirdAlertUsers);
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

    private function afterUserPlanExpire()
    {
        $expiredDate = today()->addDays(-1)->format('Y-m-d');
        $orders = UserPlanOrder::whereSubscriptionExpireAt($expiredDate)->get();

        foreach ($orders as $order) {
            if (config('system.queue.mail')){
                Mail::to($order->email)->queue(new UserPlanExpireAfterMail($order));
            } else{
                Mail::to($order->email)->send(new UserPlanExpireAfterMail($order));
            }
        }
    }

    private function beforeUserPlanExpire()
    {
        $cron = get_option('cron_option', true);
        $willExpire = today()->addDays($cron->first_expire_days)->format('Y-m-d');

        $firstOrder = UserPlanOrder::whereSubscriptionExpireAt($willExpire)->get();
        $this->sendUserPlanEmail($firstOrder);

        $willExpire = today()->addDays($cron->second_expire_days)->format('Y-m-d');
        $secondOrders =  UserPlanOrder::whereSubscriptionExpireAt($willExpire)->get();
        $this->sendUserPlanEmail($secondOrders);
    }

    private function sendUserPlanEmail($orders)
    {
        foreach ($orders as $order) {
            if (config('system.queue.mail')){
                Mail::to($order->email)->queue(new UserPlanExpireBeforeMail($order));
            } else{
                Mail::to($order->email)->send(new UserPlanExpireBeforeMail($order));
            }
        }
    }

    private function deleteTemporaryFiles()
    {
        $temporaryFiles = TemporaryFile::where('created_at', '<', today()->subDay())->get();

        foreach ($temporaryFiles as $temporaryFile) {
            $path = 'temp/' . $temporaryFile->folder;
            if (\Storage::disk(config('filesystems.default'))->exists($path)){
                \Storage::disk(config('filesystems.default'))->deleteDirectory($path);
            }

            $temporaryFile->delete();
        }
    }
}
