<?php

namespace App\Events;

use App\Models\Sale;
use Illuminate\Queue\SerializesModels;

class SendSaleEmailNotificationEvent
{
    use SerializesModels;

    /**
     * La venta recibida.
     *
     * @var Sale    La venta
     */
    public Sale $sale;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Sale $sale)
    {
        $this->sale = $sale;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return new PrivateChannel('channel-name');
    // }
}
