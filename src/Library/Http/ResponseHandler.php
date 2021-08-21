<?php


namespace tinkle\framework\Library\Http;


use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use tinkle\framework\Request;
use tinkle\framework\Tinkle;

abstract class ResponseHandler
{

    public object  $response;


    /**
     * Response constructor.
     */
    public function __construct()
    {
        $this->response = new SymfonyResponse();

    }



    /**
     * @return bool
     */
    public function send()
    {
        //$this->response->prepare($request);  [ONLY SYMFONY REQUEST OBJECT CAN BE ACCEPTED]

        $this->response->send();
        return true;
    }



    /**
     * @param string $content
     * @return SymfonyResponse
     */
    public function setContent(string $content)
    {
        return $this->response->setContent($content);
    }


    /**
     * @param string $key
     * @param string $value
     * @return bool
     */
    public function setHeader(string $key='Content-Type',string $value='text/plain')
    {
        $this->response->headers->set($key, $value );
        $this->response->setCharset('ISO-8859-1');
//        $this->response->sendHeaders();
        return true;
    }


    public function setHeaders(array $headers)
    {

        foreach ($headers as $key => $value)
        {
            $this->response->headers->set($key,$value);
        }
        $this->response->setCharset('ISO-8859-1');
  //      $this->response->sendHeaders();
        return true;
    }




    public function getHeader(string $key)
    {
        return $this->response->headers->get($key);
    }


    public function setStatusCode($code=SymfonyResponse::HTTP_ACCEPTED)
    {
        $this->response->setStatusCode($code);
    }

    public function getStatusCode()
    {
        return $this->response->getStatusCode();
    }





    // COOKIES


    /**
     * @param string $name
     * @param string $value
     * @param int $days
     * @return bool
     */
    public function setCookie(string $name, string $value,int $days=1)
    {

        $time = time() + (86400 * $days);
        if(Essential::is_https())
        {
            $this->response->headers->setCookie(SymfonyCookie::create($name,$value,$time,'/','',true  ,true,false,SymfonyCookie::SAMESITE_STRICT));
        }else{
            $this->response->headers->setCookie(SymfonyCookie::create($name,$value,$time,'/','',false  ,true,false,SymfonyCookie::SAMESITE_STRICT));
        }
        return true;
    }

    public function getCookie()
    {
        return $this->response->headers->getCookies();
    }

    public function clearCookie(string $cookieName)
    {
        return $this->response->headers->clearCookie($cookieName);
    }

    public function deleteCookie(string $cookieName)
    {
        return $this->response->headers->removeCookie($cookieName);
    }




    // Cache


    public function setCache()
    {

        $this->response->setCache([
            'must_revalidate'  => false,
            'no_cache'         => false,
            'no_store'         => false,
            'no_transform'     => false,
            'public'           => true,
            'private'          => false,
            'proxy_revalidate' => false,
            'max_age'          => 600,
            's_maxage'         => 600,
            'immutable'        => true,
            'last_modified'    => new \DateTime(),
            'etag'             => 'abcdef'
        ]);

    }



    public function redirect(string $location,int $statusCode=302,array $headers=[])
    {
        $status = $statusCode ?? 302;
        $headerDetails = $headers ?? ['Content-ColumnAttributes'=> 'text/plain'];

        $location = Tinkle::$app->request->getUrl()."/$location";

        $this->response = new RedirectResponse($location,$status,$headers);
        $this->response->send();
    }







}