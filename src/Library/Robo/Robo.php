<?php


namespace Tinkle\Library\Robo;


use Tinkle\Exceptions\Display;

class Robo
{

    protected array $config=[];
    /**
     * Robo constructor.
     * @param array $config
     */
    public function __construct(array $config=[])
    {

        dd($_GET);

        die;
        try{

            if(PHP_SAPI === 'cli')
            {
                $this->config = $config['argv'];
            }else{
                throw new Display('Robo Can Only Run In Command Line', Display::HTTP_SERVICE_UNAVAILABLE);
            }

        }catch (Display $e)
        {
            $e->Render();
        }

    }






    protected function resolve()
    {

    }














}