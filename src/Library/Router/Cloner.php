<?php


namespace Tinkle\Library\Router;


use Tinkle\Exceptions\Display;
use Tinkle\Library\Essential\Essential;
use Tinkle\Response;
use Tinkle\Tinkle;

class Cloner
{
    protected array|object $cloner;
    protected object $reflect ;
    protected object $closer;
    private string|array $parameter=[];
    private array $arguments=[];
    private string|array|object $reference;


    protected int $case=0;


    /**
     * Cloner constructor.
     * @param array|object $callback
     * @throws Display
     */
    public function __construct(array|object $callback)
    {


        try{
            if(is_object($callback))
            {
                $this->cloner = \Closure::fromCallable($callback);
                $this->reflect = new \ReflectionFunction($this->cloner);
                $this->arguments = $this->reflect->getParameters();
            }elseif (is_array($callback))
            {
                $this->cloner = \Closure::fromCallable($callback[0]);
                if(isset($callback[1]))
                {
                    $this->reference = $callback[1];

                }


                //dd($this->cloner);

                $this->reflect = new \ReflectionFunction($this->cloner);
                $this->arguments = $this->reflect->getParameters();



            }


        }catch (\ReflectionException $e)
        {
            throw new Display($e->getMessage(),Display::HTTP_SERVICE_UNAVAILABLE);
        } catch (Display $e) {
            $e->Render();
        }
    }


    public function resolve(array $parameter =[])
    {
        $this->parameter = $parameter;
        //dd($attributes,'red','white');
        try{
            if($this->prepare())
            {
                return $this->run(true);
            }else{
                return $this->run(false);
//                throw new Display("Closer Not Resolve Successfully",Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }

    }




    protected function prepare()
    {
        $this->prepareParameter();
        if(empty($this->reflect->getNumberOfRequiredParameters()))
        {
            return true;
        }else{
            return false;
        }

    }


    protected function prepareParameter()
    {
        if(is_array($this->arguments) && !empty($this->arguments))
            $argument = Essential::getHelper()->ObjectToArray($this->arguments) ?? [];
        if(!empty($argument))
        {
            foreach ($argument as $key => $value)
            {
                if(is_array($value))
                {
                    foreach ($value as $_key => $_val)
                    {
                        foreach ($this->parameter as $attrKey => $attrValue)
                        {
                            if($attrKey === $_val)
                            {
                                $this->parameter[$key][$_val]=$attrValue;
                            }
                        }
                    }
                }
            }
            unset($this->parameter[0]);
        }
        return true;
    }





    protected function run(bool|int $case=true)
    {
        try{

            if($case)
            {
                return call_user_func($this->cloner,$this->parameter);
            }else{
                return $this->prepareCloser();
            }

        }catch (Display $e)
        {
            $e->Render();
        }
    }





    private function prepareCloser()
    {

       try{


           if(!empty($this->reference))
           {
               if(!is_object($this->reference))
               {

                   $this->reference = new $this->reference(implode(',',$this->parameter));
               }

               $this->closer = $this->cloner->bindTo($this->reference);

               return call_user_func($this->closer,$this->reference);

           }else{
               if(!empty($this->parameter))
               {
                   return call_user_func($this->cloner,implode(',',$this->parameter));
               }else{
                   throw new Display("Closure Must have Same properties with Uri. Unsupported Closure Function",Display::HTTP_SERVICE_UNAVAILABLE);
               }

           }


       }catch (Display $e)
       {
           $e->Render();
       }
    }










}