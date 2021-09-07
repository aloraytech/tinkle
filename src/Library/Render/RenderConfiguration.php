<?php


namespace Tinkle\Library\Render;


use Tinkle\Library\Render\Engine\Engine;
use Tinkle\Library\Render\Themes\Themes;
use Tinkle\Tinkle;
class RenderConfiguration
{

    public static array|object $modules=[];
    public static string|array $headers=[];
    public static string $engine = Engine::NATIVE_ENGINE;
    public static string $theme='Tinkle';
    public static string $template='index';
    public static bool $isAuth=false;
    public static string $type='';

    /**
     * @param string $theme
     * @return $this
     */
    public function withTheme(string $theme)
    {
        self::$theme = $theme;
        return $this;
    }

    /**
     * @param string $template
     * @return $this
     */
    public function withTemplate(string $template)
    {
        self::$template = $template;
        if(preg_match('/^([a-z]+|[A-Z]+)/',$template,$matches))
        {
            if(strtolower($matches[0]) === 'front' || strtolower($matches[0]) === 'frontend' || strtolower($matches[0]) === 'home')
            {
                self::$type = 'frontend';
            }else{
                self::$type = 'backend';
            }
        }
        return $this;
    }


    /**
     * @param array|object $modules
     * @return $this
     */
    public function withModels(array|object $modules=[])
    {
        self::$modules = $modules;
        return $this;
    }



    /**
     * @param string $template_engine
     * @return $this
     */
    public function withTemplateEngine(string $template_engine=Engine::NATIVE_ENGINE)
    {
        self::$engine = $template_engine;
        return $this;
    }


    public function withAuth(bool $apply=false)
    {
        self::$isAuth = $apply;
        return $this;
    }

    public function generateJSON()
    {
        self::$response_type = 'json';
        return $this;
    }



    /**
     * @return array
     */
    public static function getViewConfig()
    {
        return [
            'theme' => self::$theme,
            'template'=> self::$template,
            'engine'=> self::$engine,
            'modules'=> self::$modules,
            'auth'=> self::$isAuth,
            'type'=> self::$type,
        ];
    }




}