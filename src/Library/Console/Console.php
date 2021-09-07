<?php


namespace Tinkle\Library\Console;



use Tinkle\Framework;

class Console
{


    public string $root;
    public string $request;
    public static string $divider=':';
    protected static bool $status=true;
    protected Command $command;

    /**
     * Console constructor.
     * @param array $config
     * @param string $root
     */
    public function __construct(string $root='')
    {

        $this->root = $root ?? Framework::$ROOT_DIR;
        if($this->isCli())
        {
            $this->resolveCliRequest();
        }else{
            $this->resolveWebRequest();
        }

        $this->command = new Command();


    }


    protected function generateRequest()
    {
        foreach ($_SERVER['argv'] as $key => $value)
        {
            if($key != 0)
            {
                $pattern = self::$divider;
                if(preg_match("/$pattern/",$value,$matches))
                {
                    unset($matches[0]);
                    $_GET[] = implode('/',$matches);
                }
                $_GET[] = $value;
            }
        }
        $this->request = implode('/',$_GET);

    }


    public static function resolve()
    {
        if(self::$status)
        {
            echo $this->request;
        }else{
            echo "\e[35m 
    ************************************************|
    ** WARNING - Please Run On Any Cli Application
    ************************************************|\n\e[0m";
        }


    }


    protected function isCli()
    {
        if (PHP_SAPI === 'cli')
        {
            if(defined('STDIN'))
            {
                return true;
            }

            if(isset($_SERVER['argv']) && isset($_SERVER['argc']))
            {
                return true;
            }
        }


        return false;

    }


}