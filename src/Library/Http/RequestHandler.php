<?php


namespace tinkle\framework\Library\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;


 abstract class RequestHandler
{

    public object $request;

    /**
     * RequestHandler constructor.
     *
     */
    public function __construct()
    {



//        $this->init();


        $this->request = SymfonyRequest::createFromGlobals();


    }

//    public function init()
//    {
//        SymfonyRequest::setFactory(function (
//            array $query = [],
//            array $request = [],
//            array $attributes = [],
//            array $cookies = [],
//            array $files = [],
//            array $server = [],
//            $content = null
//        ) {
//            return new Request(
//                $query,
//                $request,
//                $attributes,
//                $cookies,
//                $files,
//                $server,
//                $content
//            );
//        });
//    }


    public function getSymfonyRequest(SymfonyRequest $request)
    {
        return $request;
    }



    /**
     * @return string
     */
    public function getRequestUrl()
    {
        return $this->request->getPathInfo();
    }


    /**
     * @param bool $filter
     * @return mixed|string|null
     */
    public function getQuery (bool $filter=false)
    {
        if($filter)
        {
            return $this->request->getQueryString();
        }else{
            return $this->request->server->get('QUERY_STRING');
        }

    }


    /**
     * @param string $method
     */
    public function setMethod (string $method)
    {
        $this->request->setMethod($method);
    }

    /**
     * @return string
     */
    public function getMethod()
    {
        return strtolower($this->request->getMethod());
    }


    /**
     * @return array
     */
    public function getServer ()
    {
        return $this->request->server->all();
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getServerVar (string $key)
    {
        return $this->request->server->get($key);
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->request->getSchemeAndHttpHost();
    }


    public function getBaseUrl()
    {
        return $this->request->getBaseUrl();
    }

    public function getBasePath()
    {
        return $this->request->getBasePath();
    }


    public function getFullUrl()
    {
        return $this->getUrl().$this->getRequestUrl();
    }




    /**
     * @return string
     */
    public function getScheme()
    {
        return $this->request->getScheme();
    }


    /**
     * @return string|null
     */
    public function getClientIP ()
    {
        return $this->request->getClientIp();
    }

    /**
     * @return int|string
     */
    public function getPort ()
    {
        return $this->request->getPort();
    }

    /**
     * @return mixed|null
     */
    public function getReferBy ()
    {
        return $this->request->server->get('HTTP_REFERER');
    }





    /**\
     * @return bool
     */
    public function isGet()
    {
        return $this->getMethod() === 'get';
    }

    /**
     * @return bool
     */
    public function isPost()
    {
        return $this->getMethod() === 'post';
    }

    public function isAjax()
    {
        if($this->request->isXmlHttpRequest() || $this->request->query->get('showJson') == 1)
        {
            return true;
        }
        return false;
    }



    // This Section Methods Have to Test First Start From HERE

    /**
     * @return array
     */
    public function getAllRequestData ()
    {
        return $this->request->request->all();
    }


    /**
     * @param string $key
     * @return bool|float|int|string|null
     */
    public function getRequestData (string $key)
    {
        return $this->request->request->get($key);
    }

    /**
     * @return array
     */
    public function getAllResponseData ()
    {
        return $this->request->query->all();
    }


    /**
     * @param string $key
     * @return bool|float|int|string|null
     */
    public function getResponseData (string $key)
    {
        return $this->request->query->get($key);
    }



    /**
     * @return false|resource|string|null
     */
    public function getRequestContent ()
    {
        return $this->request->getContent();
    }

    /**
     * @return int|string|null
     */
    public function getRequestContentType ()
    {
        return $this->request->getContentType();
    }

    // This Section Methods Have to Test First END HERE


    // Cookies Related

    public function getCookie($cookie)
    {
        return $this->request->cookies->get($cookie);
    }
    public function getAllCookies()
    {
        return $this->request->cookies->all();
    }



    // Session Related

    /**
     * @return mixed
     */
    public function getSession ()
    {
        return $this->request->getSession();
    }

    /**
     * @return mixed
     */
    public function hasSession ()
    {
        if ($this->request->hasSession()){
            return true;
        }else{
            return false;
        }
    }



    /**
     * @return mixed
     */
    public function hasPreviousSession ()
    {
        return $this->request->hasPreviousSession();
    }









    // FILES RELATED


    /**
     * @return bool
     */
    public function requestHasFile ()
    {
        if (!empty($this->request->files->all()))
        {
            return true;
        }
        return false;
    }

    /**
     * @return array
     */
    public function getAllRequestFilesObject ()
    {
        return $this->request->files->all();
    }

    /**
     * @return int
     */
    public function getAllRequestFilesCount()
    {
        return $this->request->files->count();
    }




    public function postHasFiles ()
    {
        if ($this->request->files->count() > 0)
        {
            return true;
        }else{
            return false;
        }
    }

    public function hasFile($key)
    {
        return $this->request->files->has($key);
    }

    public function getRequestFileObject($key)
    {
        return $this->request->files->get($key);
    }

    public function getAllRequestFiles()
    {
        return $this->request->files->getIterator();
    }

     public function getFile(string $file)
     {
         return $this->request->files->getIterator()["$file"];
     }










}