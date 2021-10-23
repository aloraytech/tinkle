<?php


namespace Tinkle\Library\Auth;


use Tinkle\Exceptions\Display;
use Tinkle\Model;
use Tinkle\Library\Encryption\Hash;
use Tinkle\Tinkle;

class UserService
{

    private array|object $credential=[];
    private Model $serviceModel;
    private bool $exist=false;
    private array|object $user=[];
    private array|object $detail=[];

    public function __construct(array $userDetail,Model $model)
    {
        $this->serviceModel = $model;
        $this->detail = $userDetail;
        $this->credential = $this->prepare($userDetail);
        $this->resolve();
     // drydump($this->credential);
    }




    private function prepare(array $givenCredential)
    {
        $bag=[];
        foreach ($givenCredential as $key => $value)
        {
            if($key === 'first')
            {
                $bag['first'] ['field'] = $value['field'];
                $bag['first'] ['value'] = $value['value'];
            }
            if($key === 'second')
            {
                $bag['second'] ['field'] = $value['field'];
                $bag['second'] ['value'] = $value['value'];
            }
        }
        return $bag;
    }

    /**
     * @throws Display
     */
    private function resolve()
    {
            $allUser = $this->serviceModel::where($this->credential['first']['field'] ,$this->credential['first']['value'])->getAll() ?? [];

            if(!empty($allUser) && count($allUser) === 1)
            {
                if(password_verify($this->credential['second']['value'],$allUser[0]->password))
                {
                    // Login Success
                    $this->user = $allUser[0];
                    $this->exist = true;

                    if(!Tinkle::$app->session->has('users_credential'))
                    {
                        Tinkle::$app->session->set('users_credential',['config'=>$this->detail,'model'=>$this->serviceModel]);
                    }

                    if(Tinkle::$app->session->has('users_credential'))
                    {
                        ddump(Tinkle::$app->session->get('users_credential'));
                    }



                    echo "Loggin";
                }else{
                    // Login Failed
                    $this->exist = false;
                    throw new Display("Password Not Matched",Display::HTTP_SERVICE_UNAVAILABLE);
                }


            }


          // dryDump($allUser);


    }





    public function exist()
    {

    }


    public function get()
    {

    }









}