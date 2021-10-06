<?php

namespace App\Plugins\Razorpay;

use Razorpay\Api\Api;

class CustomerHandler
{

    public function __construct(Api $api)
    {
        dd($api);
    }

}