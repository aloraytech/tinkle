<?php
/**
 * User: AlorayTech
 * Date: 8/9/2021
 * Time: 2:15 PM
 */

namespace Tinkle\Library\Render;


use Tinkle\Library\Render\Template\Template;
use Tinkle\Library\Render\Theme\Theme;
use Tinkle\Request;
use Tinkle\Response;

/**
 * Class Render
 * @author  Krishanu Bhattacharya <krishanu.info@gmail.com>
 * @package Tinkle\Library\Render
 */
 class Render
{

    public static Render $render;
    private Request $request;
    private Response $response;
    private RenderHandler $renderHandler;
    private Settings $settings;

    private static string|array $output='';


    public array $givenConfig = [];


    /**
     * Render constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        self::$render = $this;
        $this->request = $request;
        $this->response = $response;
        $this->settings = new Settings();
    }


    /**
     * @param null|mixed $content
     */
    public function output($content=null)
    {
        $this->prepareOutput();
        ob_start();
        if(!empty($content) && empty(self::$output))
        {
            if(is_string($content) || is_int($content)){echo sprintf('%s',$content);}
            else{echo sprintf('%s',json_encode($content));}
        }else{
            if(!empty(self::$output))
            {
                if(is_string(self::$output) || is_int(self::$output)){echo sprintf('%s',self::$output);}
                else{echo sprintf('%s',json_encode(self::$output));}
            }
        }
        ob_end_flush();
    }

    /**
     * @param string|null|mixed $content
     */
    public static function display($content=null)
    {
        if(!empty($content))
        {
            ob_start();
            echo sprintf('%s',json_encode($content));
            ob_end_flush();
        }
    }


    public function render(string $template='', array|object $PageParams=[])
    {

        $this->settings::$template = $template;
        $this->settings::setCommonData($PageParams);
        return $this->settings;
    }

    // Start Process For Preparing Data For Output

    private function prepareOutput()
    {
        $this->getGivenConfig();
        dd($this->givenConfig);
        if(!empty($this->givenConfig['theme']))
        {
            $theme = new Theme($this->givenConfig);
            self::$output = $theme->getOutput();
        }else{
            $template = new Template($this->givenConfig);
            self::$output = $template->getOutput();
        }

        return self::$output;

    }

    private function getGivenConfig()
    {
        $this->givenConfig = $this->settings::getSettings();
        return $this->givenConfig;
    }




}