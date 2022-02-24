<?php

namespace App\Listerners;

use App\Events\SendEmailNotifyingSaleVerifiedEvent;
use App\Mail\SendEmailNotifyingSaleVerifiedEmail;
use Illuminate\Support\Facades\Mail;

class SendEmailNotifyingSaleVerifiedListener
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
     * Handle the event.
     *
     * @param  \App\Events\SendEmailNotifyingSaleVerifiedEvent  $event
     * @return void
     */
    public function handle(SendEmailNotifyingSaleVerifiedEvent $event)
    {
        $email = $event->sale->brand->email_two;

        if ($email) {
            Mail::to($email)
                ->send(new SendEmailNotifyingSaleVerifiedEmail($event->sale));
        }
    }
}
