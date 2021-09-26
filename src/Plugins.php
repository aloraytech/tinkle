<?php


namespace Tinkle;


abstract class Plugins
{

    public string $layout='master';
    public string $template='index';
    public array $pageAttribute=[];
    public string $title='';




    public function setLayout(string $layout='master')
    {
        $this->layout = $layout;
    }
    public function getLayout()
    {
        return $this->layout;
    }


    public function setTemplate(string $template='index')
    {
        $this->template = $template;
    }
    public function getTemplate()
    {
        return $this->template;
    }

    public function render(string $template='')
    {

        return Tinkle::$app->view->render->render($template,$this->pageAttribute);
    }




    /**
     * @param string $plugin
     * @param array $callback
     */
    public function setEvent(string $plugin,array $callback)
    {
        Tinkle::$app->setEvent($plugin,$callback);
    }

    /**
     * @param string $plugin
     * @param mixed $parameter
     * @return mixed
     */
    public function trigger(string $plugin, string|array|int $parameter='')
    {
        return Tinkle::$app->getEvent($plugin,$parameter);
    }




}