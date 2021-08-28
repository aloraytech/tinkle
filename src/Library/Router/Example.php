<?php


namespace Tinkle\Library\Router;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Response;
use Tinkle\Tinkle;


// Cloner Class Example  or Router Closure Reflection Class

class Example
{
    private array|object $cloner;
    private string|int|array|object $parameter='';
    private object $reflect ;
    private object $_closer;
    protected int $case=0;




    /**
     * Cloner constructor.
     * @param array|object $cloner
     */
    public function __construct(array|object $cloner)
    {

        try{

            if(is_array($cloner))
            {
                $this->cloner = \Closure::fromCallable($cloner[0]);
                $this->parameter = $cloner[1]??'';
            }elseif (is_object($cloner))
            {
                $this->cloner = \Closure::fromCallable($cloner);
                $this->case = 1;
            }else{
                throw new Display("Callback Not Supported For Url : ".Tinkle::$app->request->getFullUrl(),Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }
    }


    public function resolve()
    {

        $this->resolveCloner();
    }

    protected function resolveParameter()
    {
        dd($this->parameter);
    }


    protected function resolveCloner()
    {


        dd($this->cloner);


        try {
            $this->reflect = new \ReflectionFunction($this->cloner);
        } catch (\ReflectionException $e) {

        }

        //$closThis = $this->reflect->getClosureThis();
        if($this->case ===0)
        {
            $closParam = Essential::getHelper()->ObjectToArray($this->reflect->getParameters());
            $closParamCount = $this->reflect->getNumberOfRequiredParameters();

            if(is_array($closParam))
            {
                $_param =[];
                foreach ($closParam as $key => $param)
                {
                    if($key === 0)
                    {
                        if(is_array($param))
                        {
                            foreach ($param as $_key => $val)
                            {
                                $this->_closer = $this->reflect->getClosureThis()->$val;
                                $this->cloner = $this->cloner->bindTo($this->_closer);
                            }
                        }

                    }else{
                        $_param []= $param['name'];
                    }




                }

                if(is_callable($this->cloner))
                {
                    call_user_func($this->cloner,$this->_closer,array_values($_param));
                }
            }

        }



        //   dd($this->reflect->getParameters());




    }














}