<?php


namespace Tinkle;


use tinkle\config\Config;
use Tinkle\Library\Dictionary\Dictionary;
use Tinkle\Library\Render\Render;
use Tinkle\Library\Render\ViewSetup;

class View extends Render
{

    private string $template_file_type ='';
    private array $allowed_file_type = ['php','html','twig'];
    private array $viewParams=[];
    private static string $viewTemplate='';
    private string $htmlTemplate='';
    private static View $view;
    private static int $maxAgeForSecurity = 1;

    /**
     * View constructor.
     * @param Request $request
     * @param Response $response
     */
    public function __construct(Request $request, Response $response)
    {
        self::$view = $this;
        parent::__construct($request,$response);
    }

    /**
     * @param string $template
     * @param array $param
     * @param bool $isTwig
     * DIRECT RENDERING METHOD [EG. $this->>render('templatepath',arrayParams)]
     */
    public function render(string $template='', array $param=[], bool $isTwig=false)
    {
        $output = $this->run($template,$param);
        $output = $this->checkForBadWords($output);
        $output = $this->applyPageCSRFSecurity($output);
        $htmlDocName = str_replace(Tinkle::$ROOT_DIR."storage/views/",'',$output);
        $htmlDocName = str_replace('-','_',$htmlDocName);



        if($this->isCacheExist($htmlDocName))
        {
            $output = $this->getCache($htmlDocName);
        }else{
            if($this->prepareCache($output,$htmlDocName))
            {
                $output = $this->getCache($htmlDocName);
            }

        }

       $this->display($output);

    }



    private function checkForBadWords(string $htmlTemplate)
    {
        if(Tinkle::$app->config['app']['spellCheck'])
        {
            $spell = new Dictionary($htmlTemplate);
            if($spell->check())
            {
                return $spell->get();
            }
        }
        return  $htmlTemplate;
    }


    private function isCacheExist($templateName)
    {
        if(Tinkle::$app->session->has($templateName))
        {
            if(file_exists(Tinkle::$app->session->get($templateName)))
            {
                return true;
            }else{
                return false;
            }
        }
        return false;

    }



    private function prepareCache($htmlTemplate,$templateName)
    {
        $data = file_get_contents($htmlTemplate);
        $data = base64_encode($data);
        //require_once $htmlTemplate;
        file_put_contents(Tinkle::$ROOT_DIR."storage/views/$templateName",$data);
        Tinkle::$app->session->set($templateName,Tinkle::$ROOT_DIR."storage/views/$templateName");
        unlink($htmlTemplate);
        return true;
    }

    private function getCache($templateName)
    {
        return base64_decode(file_get_contents(Tinkle::$ROOT_DIR."storage/views/".$templateName));

    }


    public function display(string $output)
    {

        $statusCode = ViewSetup::$responseCode ?? 200;
        $this->cleanUp();

        $this->response->setStatusCode($statusCode);
        $this->response->setHeaders($this->securingHeaders());
        $this->response->setContent($output);
        $this->response->send();

    }


    private function securingHeaders()
    {
        $fullUrl = Tinkle::$app->request->getUrl();
        $onlyUrl = Tinkle::$app->request->getBaseUrl();
        $maxAge = self::$maxAgeForSecurity * 60;
        $apply = 1;
        if($apply)
        {
            $ExternalCss = "'unsafe-inline' example.com code.jquery.com https://ssl.google-analytics.com";
            $ExternalJs = "'unsafe-inline'";
            $addCssJs = ". script-src 'self' $ExternalJs;. style-src 'self' $ExternalCss;";
        }else{
            $addCssJs = '';
        }

        return [
            'Content-Security-Policy' => "default-src 'self' $fullUrl ; img-src 'self' data: ; connect-src 'self' $fullUrl ; frame-ancestors 'self' $fullUrl; frame-src 'none'; media-src 'self' *.$onlyUrl; report-uri $fullUrl/violationReportForCSP.php; object-src 'none';$addCssJs",
            'X-Powered-By' => 'Tinkle',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Strict-Transport-Security'=>"max-age=$maxAge; includeSubDomains",
            'X-Content-Security-Policy'=> "default-src 'self'",
            'X-WebKit-CSP'=> "default-src 'self'",
            'X-Content-Type-Options'=>"nosniff",
            'X-XSS-Protection'=>"1; mode=block",

        ];
    }



    private function cleanUp()
    {
        header_remove('Content-Security-Policy');
        header_remove('X-Powered-By');
        header_remove('X-Content-Security-Policy');
        header_remove('X-WebKit-CSP');

    }
















    // SETUP VIEW WITH MULTIPLE MODELS, RESPONSE CODE, CONTENT TYPE,
    // SECOND WAY TO CALL VIEW RENDER FROM A CONTROLLER
    /**
     * @param string $template
     * @return ViewSetup
     * FIRST CALL THIS METHOD FROM CONTROLLER LIKE [$this->prepare('templateName')->withModels([$modelObject]);]
     */
    public static function setView(string $template)
    {
        self::$viewTemplate = $template;
        return new ViewSetup();
    }

    /**
     * @return array
     * GET ALL INFO GENERATED
     * FROM VIEW SETUP
     */
    private static function getSetupDetails()
    {

        return [
            'template' =>self::$viewTemplate,
            'type'=> 123,
            'params'=> ViewSetup::getSetupDetails()['model'],
            'code'=>ViewSetup::$responseCode,
            'details'=> ViewSetup::getSetupDetails(),

        ];
    }

    /**
     * @return string
     * DETERMINE TEMPLATE FILE IS VALID AND
     * CHECK TYPE FOR OUR RENDERING ENGINE
     */
    private static function getTemplateType()
    {
        $fileName = Tinkle::$ROOT_DIR.'resources/views/'.self::$viewTemplate;
        if(file_exists($fileName.'.php'))
        {
            $type = 'php';
        }elseif (file_exists($fileName.'.html'))
        {
            $type = 'twig';
        }elseif (file_exists($fileName.'.twig'))
        {
            $type = 'twig';
        }else{
            $type = '';
        }

        return $type;
    }

    /**
     *  only call after setView;
     */
    public static function getView()
    {
        if(!empty(self::$viewTemplate))
        {
            $details = self::getSetupDetails();
            $type = self::getTemplateType() ?? '';
            if(!empty($type) && in_array($type,self::$view->allowed_file_type))
            {
                if($type != 'twig')
                {
                    self::$view->render($details['template'],$details['params'],true);
                }else{
                    self::$view->render($details['template'],$details['params'],false);
                }
            }else{
                echo "Unsupported Template File Type or Template Not Found";
            }
        }else{
            echo 'Preparing View or SetView Method never call to display some content';
        }

       //
    }

    private function applyPageCSRFSecurity(string $output)
    {
        $content = file_get_contents($output);
        if(preg_match('/@PAGE_CSRF/',$content,$matches))
        {
            $content = str_replace($matches[0],'<meta name="page_csrf" content="6OFEQ5JUwhyf61XLi0hgLu823qBlrPXRzYjmw1dm">',$content);
        }
        file_put_contents($output,$content);
        return $output;
    }


}