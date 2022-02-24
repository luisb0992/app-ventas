<?php

namespace App\Mail;

use App\Models\Sale;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmailNotifyingSaleVerifiedEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * La venta a verificar.
     *
     * @var Sale    La venta
     */
    public Sale $sale;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = __(':app le informa que se ha verificado la venta de la marca :brand', [
            'app'       => config('app.name'),
            'brand'     => $this->sale->brand->name,
        ]);

        return $this->view('mail.notifying-sale-verified')->subject($subject);
    }
}
