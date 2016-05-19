<?php

namespace Delivery\Events;


use Delivery\Models\Geo;
use Delivery\Models\Order;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GetLocationDeliveryman extends Event implements ShouldBroadcast
{
    use SerializesModels;

    public $geo;
    private $model;


    public function __construct(Geo $geo, Order $order)
    {
        $this->geo = $geo;
        $this->model = $order;
    }


    public function broadcastOn()
    {
        return [ $this->model->hash ];
    }
}
