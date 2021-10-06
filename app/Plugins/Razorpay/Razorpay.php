<?php

namespace App\Plugins\Razorpay;

use Razorpay\Api\Api;
use Razorpay\Api\Utility;


class Razorpay
{

    private static Api $api;
    private Utility $utility;

    private static string $apiID='rzp_test_it8rOF8PQWH9CD';
    private static string $apiSecret='A0scjjF9HXhGawYheULTcecp';


    /**
     * @param string $apiID
     * @param string $apiSecret
     */
    public function __construct(string $apiID='',string$apiSecret='')
    {
        if(!empty($apiID ))
        {
            self::$apiID = $apiID;
        }

        if(!empty($apiSecret ))
        {
            self::$apiSecret = $apiSecret;
        }

        self::$api = new Api(self::$apiID,self::$apiSecret);
        $this->utility = new Utility();





    }


    public function order()
    {
        return new OrderHandler(self::$api);
    }

    public function payment()
    {
        return new PaymentHandler(self::$api);
    }


    public function verifyPaymentSignature(array $attributes)
    {
        $allowedAttributes =['razorpay_signature','razorpay_payment_id','razorpay_order_id','razorpay_subscription_id'];
        if(in_array($attributes,$allowedAttributes))


        return $this->utility->verifyPaymentSignature($attributes);
    }








}