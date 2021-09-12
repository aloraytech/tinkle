<?php


namespace Tinkle\Library\Render;


use Tinkle\Tinkle;

class Settings
{

    public static string $template='';
    private static string $theme='';
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

    public static function setCommonData(array|object $common_data)
    {
        self::$commons = $common_data??[];
    }


    public function withTheme(string $theme='')
    {
        self::$theme = $theme;
        return $this;
    }

    public function withModules(array $modules=[])
    {
        self::$models = $modules;
        return $this;
    }

    public function withJson(bool $json=false)
    {
        self::$json = $json;
        return $this;
    }


    public function streamable(bool $status=false)
    {
        self::$streamable = $status;
        return $this;
    }

    public function withPoweredBy(string $name='Tinkle')
    {
        self::$poweredBy = $name;
        return $this;
    }

    public function withExternalCSS(bool $status=false)
    {
        self::$externalCss = $status;
        return $this;
    }

    public function withExternalJS(bool $status=false)
    {
        self::$externalJs = $status;
        return $this;
    }

    public function withExternalIframe(bool $status=false)
    {
        self::$externalIframe = $status;
        return $this;
    }

    public function withExternalMedia(bool $status=false)
    {
        self::$externalMedia = $status;
        return $this;
    }

    public function withImageBase64(bool $status=true)
    {
        self::$imgBase64 = $status;
        return $this;
    }

    public function withHeaderMaxAge(int $time_second=60)
    {
        self::$headerMaxAge = self::$headerMaxAge * $time_second;
        return $this;
    }

    // This should be mail sending type or log type in future version
    public function getCSPReportToThisFile(string $report_public_file_location='')
    {
        if(!empty($report_public_file_location))
        {
            self::$cspReport = "report-uri ".Tinkle::$app->request->getFullUrl().$report_public_file_location.";";
        }else{
            self::$cspReport = "";
        }
    }

    public function output()
    {
        return Tinkle::$app->view->render->output();
    }



    public static function getSettings()
    {

        return [
            'theme'=> self::$theme,
            'template'=> self::$template,
            'module'=> self::$models,
            'jsonOutput'=> self::$json,
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











    private static function getCSP()
    {
        $fullUrl = Tinkle::$app->request->getFullUrl();
        $onlyUrl = Tinkle::$app->request->getBaseUrl();

        if(self::$externalCss)
        {
            $part = "'unsafe-inline' example.com code.jquery.com https://ssl.google-analytics.com";
            $css = "style-src 'self' $part";
        }else{
            $css = "style-src 'self'";
        }

        if(self::$externalJs)
        {
            $js = "script-src 'self' 'unsafe-inline'";
        }else{
            $js = "script-src 'self'";
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