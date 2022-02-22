<?php

namespace App\Listerners;

use App\Events\SendSaleEmailNotificationEvent;
use App\Mail\SendSaleNotificationEmail;
use Illuminate\Support\Facades\Mail;

class SendSaleEmailNotificationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Ejecuta la acción de enviar el correo de notificación de venta.
     *
     * @param  \App\Events\SendSaleEmailNotificationEvent  $event
     * @return void
     */
    public function handle(SendSaleEmailNotificationEvent $event)
    {
        $email = $event->sale->brand->email_one;

        if ($email) {
            Mail::to($email)
                ->send(new SendSaleNotificationEmail($event->sale));
        }
    }
}
