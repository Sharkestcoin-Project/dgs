<?php

namespace App\Mail;

use App\Models\ProductOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewDownloadLinkMail extends Mailable
{
    use Queueable, SerializesModels;

    public ProductOrder $order;

    /**
     * Create a new message instance.
     *
     * @param ProductOrder $order
     */
    public function __construct(ProductOrder $order)
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
            ->subject('Your download link has been changed')
            ->markdown('mail.new-download-link-mail')
            ->with(['order', $this->order]);
    }
}
