<?php

namespace Tinkle\Exceptions;

class DeprecationHandler
{

    private string $method='';
    private string $function='';

    private string $message='';
    /**
     * @var int|mixed
     */
    private int|string $code='';

    public function __construct(string $message = '',int|string $code = 0)
    {
        $this->message = $message;
        $this->code = $code;
    }


    public function is_deprecated()
    {
        if($this->resolve())
        {
            return true;
        }else{
            return false;
        }
    }

    public function call_deprecated()
    {

    }

    private function resolve()
    {

        if(preg_match('/_msg=Call to undefined method/',$this->message,$exceptions))
        {
            // Found Method Error
            if(preg_match('/^.+\::.+\(\)&_/',$this->message,$matches))
            {

                $this->method = str_replace("_msg=Call to undefined method",'',$matches[0]);
                $this->method = str_replace("&_",'',$this->method);




            }



        }elseif (preg_match('/_msg=Call to undefined function/',$this->message,$errors))
        {
            // Found Function Error
            if(preg_match('/^.+\(\)&_/',$this->message,$matches))
            {
                $this->function = str_replace("_msg=Call to undefined function",'',$matches[0]);
                $this->function = str_replace("&_",'',$this->function);

            }




        }else{

        }



    }









}