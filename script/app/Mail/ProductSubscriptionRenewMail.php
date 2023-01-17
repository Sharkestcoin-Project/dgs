<?php

namespace App\Mail;

use App\Models\ProductOrder;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductSubscriptionRenewMail extends Mailable
{
    use Queueable, SerializesModels;

    private User $user;
    private ProductOrder $productOrder;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, ProductOrder $productOrder)
    {
        //
        $this->user = $user;
        $this->productOrder = $productOrder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject("You have a product renewal email")
            ->markdown('mail.product-subscription-renew-mail')
            ->with([
                'user' => $this->user,
                'order' => $this->productOrder
            ]);
    }
}
