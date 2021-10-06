<?php

namespace App\Controllers\Payment;

use App\Controllers\Payment\Provider\RazorPayHandler;
use Razorpay\Api\Api;
use Tinkle\Controller;
use Tinkle\Request;
use Tinkle\Response;

/**
 * Class Payment
 * @package tinkle\app\controllers
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class Payment
{

    public const RAZORPAY='razorpay';
    public const STRIPE='stripe';

    private const RAZORPAY_ID='rzp_test_it8rOF8PQWH9CD';
    private const RAZORPAY_SECRET='A0scjjF9HXhGawYheULTcecp';

    protected object $payment;


       /**
        * Payment constructor.
        */
       public function __construct(string $payment_provider)
       {

           if($payment_provider === self::RAZORPAY)
           {
               $this->payment = new RazorPayHandler(self::RAZORPAY_ID,self::RAZORPAY_SECRET);
               $customerDetails = ['email'=>'','gstin'=>''];
               $this->payment->customer->create('customer_name',$customerDetails);
           }





       }


       public function getAllOrder()
       {
            // Todo implement my_custom_method
       }



        /**
         * @param Request $request
         * @param Response $response
         */
        public function getOrder(Request $request, Response $response)
        {
            // Todo implement my_custom_method
        }


        public function createCustomer()
        {

        }

        public function getCustomer()
        {

        }







}