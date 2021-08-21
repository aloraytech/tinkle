<?php


namespace tinkle\framework;


class Event
{
    const EVENT_ON_LOAD = 'onLoad';
    const EVENT_ON_RUN = 'onRun';
    const EVENT_ON_END = 'onEnd';
    const EVENT_ON_REPEAT = 'onRepeat';

    protected array $listeners = [];
    protected string $eventName='';
    protected string $class;
    protected string $method;
    protected string $namespace;
    protected array $config=['auth'=>true,'timer'=>0,'settings'=>'','return'=>''];
    protected string $eventType= '';
    protected $ClassAttribute;
    protected $MethodAttribute;


    /**
     * Event constructor.
     */
    public function __construct()
    {
       //
        if(!array_key_exists('raw',$this->listeners))
        {$this->listeners['raw'] =[];}
        if(!array_key_exists('mask',$this->listeners))
        {$this->listeners['mask'] =[];}
    }


    /**
     * @param $constract_key
     * @return bool|null
     */
    public function setClassAttribute($constract_key)
    {
        if(!empty($constract_key))
        {

            if(is_array($constract_key))
            {
                $_defaultClassAttributes = ['_1key'=>'[]','_2key'=>'[]','_3key'=>'[]','_4key'=>'[]','_5key'=>'[]','_6key'=>'[]','_7key'=>'[]'];
                $this->ClassAttribute = array_intersect_key($constract_key,$_defaultClassAttributes);
            }

            if(is_string($constract_key) || is_int($constract_key))
            {
                $this->ClassAttribute = $constract_key;
            }
        }else{
            $this->ClassAttribute = '';
        }
    }


    /**
     * @param $type
     * @param $name
     * @param array $param
     * @param array $config
     */
    public function prepare($type,$name,$param=[],$config=[])
    {
        if(!empty($type) && !empty($name))
        {

            if($type === self::EVENT_ON_LOAD || $type === self::EVENT_ON_RUN || $type === self::EVENT_ON_REPEAT || $type === self::EVENT_ON_END)
            {
                $this->eventType = $type;
                $this->eventName = $name;
                if($this->prepareClassAndMethod())
                {
                    $this->MethodAttribute = $param;

                    if($this->prepareConfig($config))
                    {
                        if($this->fillIntoListners('raw',"$this->eventName"))
                        {
                            $this->fillIntoListners('mask',"$this->class::$this->method");
                        }else{
                            echo "Error: Unsupported Class And Method Name Format";
                        }
                    }else{
                        echo "Error: Unsupported Event Config";
                    }


                }else{
                    echo "Error: Unsupported Class And Method Name Format";
                }

            }else{
                echo "Error: Wrong Event ColumnAttributes Found for $name";
            }

        }else{
            echo "Error: Event ColumnAttributes Not Set Found for $name";
        }
    }

    /**
     *  For Complete Single Event Preparation
     */
    public function finish()
    {
        $this->setClassAttribute('');
    }


    /**
     * @param $eventName
     * @param $eventType
     * @param array $param
     * @return mixed
     */
    public function callEvent($eventName,$eventType='',$param=[],$config=[])
    {
        $callback = $this->listeners['raw'][$eventName] ?? [];
        if(empty($callback))
        {
            $callback = $this->listeners['mask']["$eventName"] ?? [];
            if(empty($callback))
            {
                $callback = $this->listeners['mask']["$eventName.$eventType"] ?? [];
            }

        }


        $eventObject = $this->prepareObject($callback);
        $eventMethod = $callback['method'];
        $eventMethodParam = $callback['methodAttribute'];

        if($eventMethodParam === null || empty($eventMethodParam))
        {
            $eventMethodParam = '';
        }
        if(!empty($param))
        {
            $eventMethodParam = $param;
        }

        // Now Call Event And Return Result
        if(!is_null($eventObject) && !is_null($eventMethod) && !is_null($eventMethodParam))
        {
            return call_user_func_array( [ $eventObject,"$eventMethod"], $eventMethodParam);
        }

    }


    /**
     * @return mixed
     */
    protected function getClassAttribute()
    {
        return $this->ClassAttribute;
    }



    /**
     * @return bool
     */
    protected function prepareClassAndMethod()
    {
        if(!empty($this->eventName))
        {
            if(preg_match('/\w+::\w+$/',$this->eventName,$matches))
            {
                    if(preg_match('/^([A-Z]{1}[a-z]+[A-Z]{1}[a-z]+|[A-Z]{1}[a-z]+)/',$matches[0],$e_class))
                    {
                        $this->class = $e_class[0];
                        if(preg_match('/::([A-Z]{1}[a-z]+|[a-z]+[A-Z]{1}[a-z]+)$/',$matches[0],$e_method))
                        {
                            $this->method = str_replace("::",'',$e_method[0]);
                            $this->namespace = str_replace("$this->class::$this->method","",$this->eventName);
                            //Now We Get All Individual Values of Our Class Parameters
                            return true;
                        }else{
                            echo "Error: Can't understand the class name";
                            return false;
                        }
                    }else{
                        echo "Error: Can't understand the class name";
                        return false;
                    }
            }else{
                echo "Error: Wrong Class Name Format Found";
                    return false;
            }
        }else{
            echo "Event Name not Set";
            return false;
        }
    }


    /**
     * @param array $config
     * @return bool
     */
    protected function prepareConfig(array $config=[])
    {
        if(!empty($config))
        {
            if(is_array($config))
            {
                    $this->config = array_replace($this->config,array_intersect_key($config,$this->config));
                    if( $this->config['auth'] === false || $this->config['auth'] !== 1 || $this->config['auth'] === null)
                    {
                        $this->config['auth'] = 0;
                    }
                    return true;

            }else{
                return false;
            }

        }else{
            return true;
        }

    }



    /**
     * @param string $key
     * @param string $name
     * @return bool
     */
    protected function fillIntoListners(string $key,string $name)
    {
        if(!array_key_exists("$name",$this->listeners["$key"]))
        {
            $this->listeners[$key][$name]['namespace'] = $this->namespace;
            $this->listeners[$key][$name]['class'] = $this->class;
            $this->listeners[$key][$name]['method'] = $this->method;
            $this->listeners[$key][$name]['type'] = $this->eventType;
            $this->listeners[$key][$name]['config'] = $this->config;
            $this->listeners[$key][$name]['methodAttribute'] = $this->MethodAttribute;
            $this->listeners[$key][$name]['classAttribute'] = $this->getClassAttribute();
            return true;
        }else{
            // Special Case [Event ColumnAttributes Change On Existing Event Case]
            if (array_key_exists("$name", $this->listeners["$key"])  && $this->listeners[$key]["$name"]['type'] !== $this->eventType)
            {
                $this->listeners[$key]["$name.$this->eventType"]['namespace'] = $this->namespace;
                $this->listeners[$key]["$name.$this->eventType"]['class'] = $this->class;
                $this->listeners[$key]["$name.$this->eventType"]['method'] = $this->method;
                $this->listeners[$key]["$name.$this->eventType"]['type'] = $this->eventType;
                $this->listeners[$key]["$name.$this->eventType"]['config'] = $this->config;
                $this->listeners[$key]["$name.$this->eventType"]['methodAttribute'] = $this->MethodAttribute;
                $this->listeners[$key]["$name.$this->eventType"]['classAttribute'] = $this->getClassAttribute();
                return true;
            }else{
                return false;
            }
            // Special Case
        }
    }

    /**
     * @param $callback
     * @return false|mixed
     */
    protected function prepareObject($callback)
    {
       $_1key = []; $_2key = []; $_3key = []; $_4key = []; $_5key = []; $_6key = []; $_7key = [];

        $namespace = $callback['namespace'];
        $class = $callback['namespace'] . $callback['class'];
        $attribute = $callback['classAttribute'];



            if(is_array($attribute))
            {
                    extract($attribute);

                    switch (count($attribute)) {
                        case 1:
                            return new $class($_1key);
                            break;
                        case 2:
                            return new $class($_1key,$_2key);
                            break;
                        case 3:
                            return new $class($_1key,$_2key,$_3key);
                            break;
                        case 4:
                            return new $class($_1key,$_2key,$_3key,$_4key);
                            break;
                        case 5:
                            return new $class($_1key,$_2key,$_3key,$_4key,$_5key);
                            break;
                        case 6:
                            return new $class($_1key,$_2key,$_3key,$_4key,$_5key,$_6key);
                            break;
                        case 7:
                            return new $class($_1key,$_2key,$_3key,$_4key,$_5key,$_6key,$_7key);
                            break;
                        default:
                            return false;
                    }
            }else{
                return new $class($attribute);
            }




    }


    public function displayListners()
    {
        echo "<br><pre>";
        print_r($this->listeners);
        echo "</pre><br>";
    }



//    public static function set($type,$name,$param=[],$config=[])
//    {
//
//        return self::class->prepare($type,$name,$param=[],$config=[]);
//    }
//
//
//    public static function setClassParam($construct_key)
//    {
//        return static::setClassAttribute($construct_key);
//    }
//
//    public static function build()
//    {
//        return static::finish();
//    }
//
//    public static function call($eventName,$eventType,$param=[],$config=[])
//    {
//        return self::callEvent($eventName,$eventType,$param=[],$config=[]);
//    }



/**
 * EXAMPLE CALL AN EVENT
 *    $this->event->callEvent('UserController::updateUser',EVENT::EVENT_ON_REPEAT,['user'=> 'Google']);
// $this->event->callEvent('Sample::loadData',EVENT::EVENT_ON_REPEAT);


$this->event->callEvent('UserController::updateUser');
//$this->event->displayListners();

 */





    // Class End

}