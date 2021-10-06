<?php

namespace App\Controllers\Payment\Provider;

use Razorpay\Api\Api;
use Tinkle\Controller;
use Tinkle\Request;
use Tinkle\Response;

/**
 * Class RazorPay
 * @package tinkle\app\controllers
 * @author : krishanu.info@gmail.com
 * @version : 1.0
 */
class RazorPayHandler
{

    private const CUSTOMER_API = 'https://api.razorpay.com/v1/customers';
    private const ORDER_API = 'https://api.razorpay.com/v1/orders';
    private const PAYMENT_API = 'https://api.razorpay.com/v1/payments/';
    private const STATEMENT_API = 'https://api.razorpay.com/v1/settlements';
    private const REFUND_API = 'https://api.razorpay.com/v1/refunds';
    private const INVOICE_API='https://api.razorpay.com/v1/invoices';
    private const PAYMENT_LINK_API='https://api.razorpay.com/v1/payment_links';
    private const ITEM_API='https://api.razorpay.com/v1/items';



    private object $api;
    public  RazorPayHandler $razorpay;
    public  Customer $customer;
    private array $allowedCustomerDetails=['name','email','fail_existing','contact','gstin','notes'];

    /**
     * RazorPay constructor.
     * @param string $razorpay_key
     * @param string $razorpay_secret
     */
       public function __construct(string $razorpay_key, string $razorpay_secret)
       {
           $this->api = new Api($razorpay_key,$razorpay_secret);
           $this->api->setAppDetails($_ENV['APP_NAME'],'v5');
           $this->customer = new Customer();

       }


        /**
         * @param Request $request
         * @param Response $response
         */
       public function my_custom_method(Request $request, Response $response)
       {
            // Todo implement my_custom_method
       }

       public function addOrder()
       {
           $url = 'http://server.com/path';
           $data = array('key1' => 'value1', 'key2' => 'value2');

       }




















       private function fetch(string $url,array $data,$method)
       {
           try{

               $options = array(
                   'http' => array(
                       'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                       'method'  => strtoupper($method),
                       'content' => http_build_query($data)
                   )
               );
               $context  = stream_context_create($options);
               $result = file_get_contents($url, false, $context);
               if (empty($result))
               {
                   throw new \Exception('Check your Razorpay Credential',503);
               }else{
                    return $result;
               }

           }catch (\Exception $e)
           {
               $e->getMessage();
           }

       }








}