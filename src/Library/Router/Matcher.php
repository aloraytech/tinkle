<?php


namespace Tinkle\Library\Router;


class Matcher
{

    public string $request_url = '';
    public string $request_method = '';
    protected array $groupRoutes=[];

    protected const DEFAULT_GROUP='_WEB';
    protected const DEFAULT_REDIRECT_GROUP='_REDIRECT';
    protected const API_GROUP='_API';
    protected const PLATFORM_GROUP='_PLATFORM';

    protected array $currentRoute=[];

    /**
     * Matcher constructor.
     * @param array $routes
     * @param string $url
     * @param string $method
     */
    public function __construct(array $routes,string $url, string $method)
    {
        $this->groupRoutes = $routes;
        //dd($routes);
        $this->request_url = $url;
        $this->request_method = $method;

//        dd($this->groupRoutes);

    }


    protected function getUrlParts()
    {
        return explode('/',$this->request_url);
    }


    public function findOrFail()
    {

        return $this->exploreGroup();
    }




    private function exploreGroup()
    {

        if(array_key_exists($this->request_method,$this->groupRoutes))
        {
                $availableRoutes = $this->groupRoutes[$this->request_method];

                if (!empty($this->findCustomGroup($availableRoutes)))
                {
                        return $this->currentRoute;
                }elseif (!empty($this->findWebGroup($availableRoutes)))
                {
                    return $this->currentRoute;
                }elseif (!empty($this->findApiGroup($availableRoutes)))
                {
                    return $this->currentRoute;
                }elseif (!empty($this->findRedirectGroup($availableRoutes)))
                {
                    return $this->currentRoute;
                }elseif (!empty($this->findPlatformGroup($availableRoutes)))
                {
                    return $this->currentRoute;
                }else{
                    return [];
                }


        }

    }


    private function findCustomGroup(array $availableRoutes)
    {
        $urlParts = $this->getUrlParts();
        if(array_key_exists(strtoupper($urlParts[0]),$availableRoutes))
        {
            return $this->found($availableRoutes[strtoupper($urlParts[0])]);
        }
        return null;
    }



    private function findWebGroup(array $availableRoutes)
    {
        if(array_key_exists(self::DEFAULT_GROUP,$availableRoutes))
        {
            return $this->found($availableRoutes[self::DEFAULT_GROUP]);
        }
        return null;
    }



    private function findRedirectGroup(array $availableRoutes)
    {
        if(array_key_exists(self::DEFAULT_REDIRECT_GROUP,$availableRoutes))
        {
            return $this->found($availableRoutes[self::DEFAULT_REDIRECT_GROUP]);
        }
        return null;
    }


    private function findApiGroup(array $availableRoutes)
    {
        if(array_key_exists(self::API_GROUP,$availableRoutes))
        {
            return $this->found($availableRoutes[self::API_GROUP]);
        }
        return null;
    }



    private function findPlatformGroup(array $availableRoutes)
    {
        if(array_key_exists(self::PLATFORM_GROUP,$availableRoutes))
        {
            return $this->found($availableRoutes[self::PLATFORM_GROUP]);
        }
        return null;
    }

















    private function found(array $availableRoutes)
    {
        $found =[];
        foreach ($availableRoutes as $uri => $route)
        {
            if(is_array($route))
            {

                if(preg_match($uri,$this->request_url,$matches))
                {

                    $found[$uri] = $route;
                    $params = [];
                    foreach ($matches as $_key => $match) {
                        if (is_string($_key)) {
                            $params[$_key] = $match;
                        }

                    }
                    $found [$uri]['param'] = $params;
                }
            }

        }
        if(!empty($found))
        {
            $this->currentRoute = $found;
        }
        return $found;
    }
















}