<?php

namespace App\Mail;

use App\Models\UserPlanOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SubscriptionRenewalMail extends Mailable
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
            ->subject('Subscription Renewal Notification')
            ->markdown('mail.subscription-renewal-mail')
            ->with('order', $this->order);
    }
}
