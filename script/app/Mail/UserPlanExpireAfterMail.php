<?php

namespace App\Mail;

use App\Models\UserPlanOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPlanExpireAfterMail extends Mailable
{
    use Queueable, SerializesModels;

    private UserPlanOrder $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(UserPlanOrder $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(__('Your Subscription Plan Has Been Expired'))
            ->markdown('mail.user-plan-expire-after-mail')
            ->with('order', $this->order);
    }
}
