<?php


namespace Themes\Kartoos;

use Tinkle\Library\Render\Theme\Theme;

class Kartoos extends Theme
{



    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Master';
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return 'Krishanu';
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return 'v.001';
    }

    /**
     * @return string
     */
    public function getUpdateFrom(): string
    {
        return 'http://authorurl.com';
    }

    /**
     * @return string
     */
    public function getLogo(): string
    {
        return 'assets/logo.png';
    }

    /**
     * @return array
     */
    public function getPreviewImages(): array
    {
        return [
            'assets/slideOne.png','assets/slideTwo.png','assets/slideThree.png',
        ];
    }

    /**
     * @return bool
     */
    public function isFront(): bool
    {
        return true;
    }

    /**
     * @return bool
     */
    public function isBack(): bool
    {
        return true;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return ['thinking'];
    }

    /**
     * @return array
     */
    public function getCSS(): array
    {
        return [
            'bootstrap.min.css'=> 'css/bootstrap.min.css',
            'animate.min.css'=> 'css/animate.min.css',
            'sidebars.css'=> 'css/sidebars.css'
        ];
    }

    /**
     * @return array
     */
    public function getJS(): array
    {
        return [
            'bootstrap.min.js'=> 'js/bootstrap.min.js',
            'sidebars.js'=> 'js/sidebars.js'
        ];
    }

    /**
     * @return string
     */
    public function getComponent(): string
    {
        return 'component/';
    }


    /**
     * @return string
     */
    public function getIndex(): string
    {
        return 'pages/index.html';
    }


    /**
     * @return array
     */
    public function getPages(): array
    {
        return [

        ];
    }

}