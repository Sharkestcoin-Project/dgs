<?php

namespace App\Mail;

use App\Models\User;
use App\Models\UserPlanOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewSubscriptionMail extends Mailable
{
    use Queueable, SerializesModels;

    private string $type;
    private User $user;
    private array $data;
    private UserPlanOrder $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $type, User $user, array $data, UserPlanOrder $order)
    {
        $this->type = $type;
        $this->user = $user;
        $this->data = $data;
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
            ->subject($this->type == 'customer' ? __('You are subscribe to a new plan') : __('You have a new subscriber') )
            ->markdown('mail.new-subscription-mail')
            ->with([
                'type' => $this->type,
                'user' => $this->user,
                'data' => $this->data,
                'order' => $this->order
            ]);
    }
}
