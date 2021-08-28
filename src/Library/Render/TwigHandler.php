<?php


namespace Tinkle\Library\Render;


use Tinkle\interfaces\RenderHandlerInterface;

class TwigHandler implements RenderHandlerInterface
{
    public array $config=[];
    public string $template='';
    public array $param=[];
    protected string $path = '';


    /**
     * TwigHandler constructor.
     * @param string $template
     * @param array $param
     * @param array $config
     */
    public function __construct(string $template='',array $param=[],array $config)
    {
        $this->template = $template;
        $this->param = $param;
        $this->config = $config;
        $this->path = $this->config['path'];
    }


    public function resolve(): bool
    {
        // TODO: Implement resolve() method.
    }


    public function display()
    {
        // TODO: Implement display() method.
    }
}