<?php


namespace Themes\DefaultTheme;


use Tinkle\interfaces\ThemeInterface;
use Tinkle\Library\Render\Engine\Engine;

class DefaultTheme implements ThemeInterface
{

    protected string $themeRoot = __DIR__.'/';

    public function getInfo(): array
    {
        return [
            'name'=> 'DefaultTheme',
            'author'=> 'Krishanu Bhattacharya',
            'version'=> 'v.1.001',
            'description'=> 'Tinkle Default Theme',
            'type'=>'blog',
            'logo'=> $this->themeRoot."assets/media/theme_logo.png",
        ];
    }

    public function getConfig(): array
    {
        return [];
    }

    public function getAvailablePages(): array
    {
        return [
            'layout'=> [
                'front'=>$this->themeRoot.'layout/master.php',
                'back'=>$this->themeRoot.'layout/dashMaster.php'
            ],
            'front'=>[
                'home'=> $this->themeRoot."front/index.php",
                'category'=> $this->themeRoot."front/category.php",
            ],
            'back'=>[
                'home'=>'',
                'category'=>'',
            ],
        ];
    }

    public function getAvailableCss(): array
    {
        return [
            'frontend'=>[
                'bootstrap.min'=> $this->themeRoot."assets/css/bootstrap.min.css",
                'sidebar'=> $this->themeRoot."assets/css/sidebar.css",
                ],
            'backend'=>[],
        ];
    }

    public function getAvailableJs(): array
    {
        return [
            'frontend'=>[
                'bootstrap.min'=> $this->themeRoot."assets/js/bootstrap.min.js",
                'sidebar'=> $this->themeRoot."assets/js/sidebar.js",
            ],
            'backend'=>[],
        ];
    }

    public function getAvailableMedia(): array
    {
        return [
            'frontend'=>[
                'favicon'=> $this->themeRoot."assets/media/favicon.ico",
            ],
            'backend'=>[],

        ];
    }

    public function isFrontend(): bool
    {
        return true;
    }

    public function isBackend(): bool
    {
        return false;
    }


    public function getTemplateEngine(): string
    {
        return Engine::NATIVE_ENGINE;
    }
}