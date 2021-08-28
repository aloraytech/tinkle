<?php


namespace Tinkle\Library\Render;


class ViewSetup
{
    const CONTENT_TYPE_TEXT ='text/plain';
    const CONTENT_TYPE_IMAGE='';
    const CONTENT_TYPE_FILE='';


    public static array $modelsForView = [];
    public static int $responseCode;
    public static string $contentType='';


        public function withModels( array $models)
        {
            self::$modelsForView = $models;
            return $this;
        }

        public function responseCode(int $code=200)
        {
            self::$responseCode = $code;
            return $this;
        }





    public static function getSetupDetails()
    {
        return [
            'model'=> self::$modelsForView,
            'code'=> self::$responseCode,
        ];
    }



}