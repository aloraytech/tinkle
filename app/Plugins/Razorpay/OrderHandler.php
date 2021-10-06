<?php

namespace App\Plugins\Razorpay;

use Razorpay\Api\Api;
use Razorpay\Api\Order;

class OrderHandler
{

    private Api $api;
    private Order $order;

    public function __construct(Api $api)
    {
        $this->api = $api;


    }

    public function create()
    {
       return $this->api->order->create(array('receipt' => '123', 'amount' => 100, 'currency' => 'INR'));

    }

    public function getCreateID()
    {

    }

    public function all(array $options)
    {
        return $this->api->order->all($options);
    }

    public function fetch(string|int $orderId)
    {
        return $this->api->order->fetch($orderId);
    }

    public function getPayments(string|int $orderId)
    {
        return $this->api->order->fetch($orderId)->payments();
    }












}