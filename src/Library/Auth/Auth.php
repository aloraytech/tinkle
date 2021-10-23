<?php


namespace Tinkle\Library\Auth;


use App\Provider\AuthProvider;
use Tinkle\Exceptions\CoreException;
use Tinkle\Exceptions\Display;
use Tinkle\Model;
use Tinkle\Tinkle;

class Auth
{
    private static Auth $auth;
    private AuthProvider $provider;
    protected Model $authModel;
    private static array $guardBag=[];
    private static UserService $user;
    private static array|object $userCredential=[];
    private static array $allowedCredentialkeys=['first','second','confirmSecond'];
    private static string $guard='web';

    public function __construct()
    {
        self::$auth = $this;
        $this->provider = new AuthProvider();
    
        $this->resolveGuardBag();
    }


    private function resolveGuardBag()
    {
        $allGuard = $this->provider->setGuards();
        $guardModel = $this->provider->setGuardModel();
        foreach ($allGuard as $key => $guard)
        {
            foreach ($guardModel as $gmKey => $model)
            {
                if($guard === $gmKey)
                {
                    self::$guardBag[$guard] = [
                        'model'=> $model,
                        'expire' => $this->provider->setExpire(),
                        'timeout'=>$this->provider->setTimeout(),
                    ];
                }
            }
        }

    }


    public static function guard(string $guardName='web')
    {
        self::$guard = $guardName;
        return self::$auth;
    }


    /**
     * @throws Display
     */
    public static function attempt(array $credential)
    {

        if(empty(self::$userCredential))
        {
            echo "First";
            //Load Guard
            if(isset(self::$guardBag[self::$guard]))
            {
                // Take specific guard model from guardBag
                $model = self::$guardBag[self::$guard]['model'];
                // Create Instance of Specific Model
                $instance = new $model();
                if($instance instanceof Model)
                {
                    $credentialAttributes = $instance->getCredential();

                    self::$userCredential = $instance->vefifyCredential($credential,$credentialAttributes);

                    if(!empty(self::$userCredential) && count(self::$userCredential) === 3)
                    {

                        self::$auth->createOrUse(self::$userCredential,$instance);

                    }



                }else{
                    throw new Display("$model must be instance of Model", CoreException::HTTP_SERVICE_UNAVAILABLE);
                }
            }
        }else{
            echo "Second";
            if(!is_object(self::$userCredential['model']))
            {
                $instance = new self::$userCredential['model']();
            }else{
                $instance = self::$userCredential['model'];
            }

            self::$auth->createOrUse(self::$userCredential,$instance);
        }





    }

    /**
     * @throws Display
     */
    private function createOrUse(array $credentialData, Model $model)
    {
        if(!empty($credentialData) && !empty($credentialData['first']['value']) && !empty($credentialData['second']['value']) && !empty($credentialData['confirmSecond']['value']))
        {
            self::$user = new UserService($credentialData,$model);
        }else{
            throw new Display("Given Credential Can't be Empty",Display::HTTP_SERVICE_UNAVAILABLE);
        }

    }



    public static function isAuth(){}

    public static function isGuest(){}




}