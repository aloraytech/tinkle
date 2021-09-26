<?php


namespace Tinkle\Library\Render\Config;


use Tinkle\Tinkle;
use Tinkle\View;

class Config
{


    public static string $template='';
    public static string $theme='';
    private static array $models=[];
    private static bool $json=false;
    public static array|object $commons=[];

    private static bool $streamable=false;
    private static string $poweredBy='Tinkle';
    private static bool $externalCss=false;
    private static bool $externalJs=false;
    private static bool $externalIframe=false;
    private static bool $externalMedia=false;
    private static bool $imgBase64=false;
    private static int $headerMaxAge=1;
    private static string $cspReport='';

    private static string $externalCSSHosts='';
    private static string $externalJSHosts='';

    public static function setCommonData(array|object $common_data)
    {
        self::$commons = $common_data??[];
    }




    public function withModules(array|object $modules=[])
    {
        self::$models[] = $modules;
        return $this;
    }


    public function getJson()
    {
        return View::json(self::getSettings());

    }



    public function display()
    {
        return View::handle('',self::getSettings());
    }


    public function withHeader()
    {
        return new HeaderHelper($this);
    }



    // STATIC CONFIGURATION

    public static function streamable(bool $status=false)
    {
        self::$streamable = $status;
    }

    public static function withPoweredBy(string $name='Tinkle')
    {
        self::$poweredBy = $name;
    }



    public static  function withExternalIframe(bool $status=false)
    {
        self::$externalIframe = $status;
    }

    public static  function withExternalMedia(bool $status=false)
    {
        self::$externalMedia = $status;
    }

    public static function withImageBase64(bool $status=true)
    {
        self::$imgBase64 = $status;
    }

    public static function withHeaderMaxAge(int $time_second=60)
    {
        self::$headerMaxAge = self::$headerMaxAge * $time_second;
    }

    // This should be mail sending type or log type in future version
    public static function getCSPReportToThisFile(string $report_public_file_location='')
    {
        if(!empty($report_public_file_location))
        {
            self::$cspReport = "report-uri ".Tinkle::$app->request->getFullUrl().$report_public_file_location.";";
        }else{
            self::$cspReport = "";
        }
    }


    public static function withExternalCSS(bool $status=false,string $cssHost='')
    {
        self::$externalCss = $status;
        self::$externalCSSHosts = $cssHost;
    }

    public static function withExternalJS(bool $status=false, string $jsHost='')
    {
        self::$externalJs = $status;
        self::$externalJSHosts = $jsHost;
    }





    // PREPARING SETTINGS FOR VIEW

    public static function getSettings()
    {

        return [
            'theme'=> self::$theme,
            'template'=> self::$template,
            'module'=> self::$models,
            'common'=> self::$commons??[],
            'header'=>[
                'Content-Security-Policy'=> self::getCSP(),
                'X-Powered-By' => self::$poweredBy,
                'X-Frame-Options' => 'SAMEORIGIN',
                'Strict-Transport-Security'=>"max-age=".self::$headerMaxAge."; includeSubDomains",
                'X-Content-Security-Policy'=> "default-src 'self'",
                'X-WebKit-CSP'=> "default-src 'self'",
                'X-Content-Type-Options'=>"nosniff",
                'X-XSS-Protection'=>"1; mode=block",
            ],
        ];
    }









    // CONTENT SECURITY POLICY GENERATOR

    private static function getCSP()
    {
        $fullUrl = Tinkle::$app->request->getFullUrl();
        $onlyUrl = Tinkle::$app->request->getBaseUrl();

        if(!empty(self::$externalCSSHosts))
        {
            self::$externalCSSHosts = ' '. str_replace(',',' ',self::$externalCSSHosts);
        }
        if(!empty(self::$externalJSHosts))
        {
            self::$externalJSHosts = ' '. str_replace(',',' ',self::$externalJSHosts);
        }

        $css = "style-src 'self'";
        $js = "script-src 'self'";
        if(self::$externalCss)
        {
            $default = "code.jquery.com https://ssl.google-analytics.com";
            $part = "'unsafe-inline'".$default.self::$externalCSSHosts;
            $css = $css. $part;
        }

        if(self::$externalJs)
        {
            $default = "'unsafe-inline'";
            $js = $js.$default.self::$externalJSHosts;
        }

        if(self::$externalIframe)
        {
            $iframe = "frame-ancestors 'none';
               frame-src 'none'";
        }else{
            $iframe = "frame-ancestors 'self' $fullUrl;
               frame-src 'none'";
        }

        if(self::$externalMedia)
        {
            $media = "media-src 'none'";
        }else{
            $media = "media-src 'self' *.$onlyUrl";
        }

        if(self::$imgBase64)
        {
            $image = "img-src 'self' data: ";
        }else{
            $image = "img-src 'self'";
        }

        return "default-src 'self' $fullUrl ;$image; connect-src 'self' $fullUrl ;$iframe; $media;object-src 'none';$css;$js;".self::$cspReport;
    }









}