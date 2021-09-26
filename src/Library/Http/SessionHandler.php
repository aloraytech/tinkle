<?php


namespace Tinkle\Library\Http;

use Tinkle\Library\Essential\Essential;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\Session\Storage\Handler\PdoSessionHandler;

use Tinkle\Tinkle;

abstract class SessionHandler
{


    public object $session;
    public object $dbSession;

    /**
     * Session constructor.
     */
    public function __construct()
    {

        $this->session = new SymfonySession(new NativeSessionStorage($this->preDefineOptions()), new AttributeBag());

        //$this->dbSession = new PdoSessionHandler(Tinkle::$app->db->getConnect(),$this->preDefineSessionDBStorageOptions());

        if($this->createSessionTableInDB())
        {
            if(!$this->session->isStarted())
            {
//            echo "Hello";
                // How Start Session With Value
                //$this->start('TinkleTime','token key type');
                $id = bin2hex(random_bytes(52));
                $this->session->setId($id);
                $this->session->setName('Tinkle');
                $this->session->start();
            }
        }







    }

    public function start(string $name, string $id)
    {
        $this->session->setId($id);
        $this->session->setName($name);
        $this->session->start();
        return true;
    }

    public function regenerate()
    {
        $this->session->migrate(true);
    }


    public function destroy(int $lifetime=null)
    {
        $this->session->invalidate($lifetime);
    }

    public function getSessionID()
    {
        return $this->session->getId();
    }

    public function getSessionName()
    {
        return $this->session->getName();
    }


    public function sessionExist()
    {
        return $this->session->isStarted();
    }


    /**
     * @param string $_key
     * @param $_value
     * @param bool $record
     */
    public function set(string $_key, $_value,bool $record=false)
    {
        return $this->session->set($_key,$_value);
    }

    public function get(string $key)
    {
        return $this->session->get($key);
    }

    public function has(string $key)
    {
        return $this->session->has($key);
    }

    public function replace(array $attributes)
    {
        return $this->session->replace($attributes);
    }

    public function getAllSessionKeys()
    {
        return $this->session->all();
    }

    public function clearAllSessionKeys()
    {
        return $this->session->clear();
    }
    public function remove(string $_key)
    {
        return $this->session->remove($_key);
    }



    // Flash Messages

    public function setFlash(string $flash_key, string $message)
    {
        return $this->session->getFlashBag()->add($flash_key,$message);
    }

    public function getFlash(string $flash_key)
    {
        return $this->session->getFlashBag()->get($flash_key);
    }

    public function getFlashAsReadOnly(string $flash_key)
    {
        return $this->session->getFlashBag()->peek($flash_key);
    }

    public function hasFlash(string $flash_key)
    {
        return $this->session->getFlashBag()->has($flash_key);
    }


    public function getAllFlash()
    {
        return $this->session->getFlashBag()->all();
    }








    // SESSION DB STORAGE


//
//    public function setRecord(string $_key,string|array|int $_record)
//    {
//         $this->dbSession->open(Tinkle::$app->db->getConnect(),$this->getSessionName());
//         $this->dbSession->write($_key,json_encode($_record));
//         $this->dbSession->close();
//    }
//
//
//    public function getRecord(string $_key)
//    {
//        $this->dbSession->open(Tinkle::$app->db->getConnect(),$this->getSessionName());
//        $data = $this->dbSession->read($_key);
//        $this->dbSession->close();
//        return $data;
//    }
//
//    public function hasRecord(string $_key)
//    {
//        $this->dbSession->open(Tinkle::$app->db->getConnect(),$this->getSessionName());
//        if($this->dbSession->validateId($_key))
//        {
//            $this->dbSession->close();
//            return true;
//        }
//        $this->dbSession->close();
//        return false;
//    }
//
//    public function removeRecord(string $_key)
//    {
//        return $this->dbSession->destroy($_key);
//    }
//
//    public function updateRecord(string $_key,string|array|int $_value)
//    {
//        return $this->dbSession->updateTimestamp($_key,json_encode($_value));
//    }
//

















    /**
     * @return bool
     */

    public function createSessionTableInDB()
    {
//         Tinkle::$app->db->query("SHOW TABLES LIKE 'sessions'");
//        $result = Tinkle::$app->db->resultSet();
//        if(!empty($result))
//        {
//            $has = 1;
//        }else{
//            $has = 0;
//        }
//        if(!$has)
//        {
//            $this->dbSession->createTable();
//        }
        return true;
    }









    /**
     * PRIVATE METHODS
     */


    private function preDefineOptions()
    {
        return [
            'cache_limiter' => 'private',
            'cache_expire' => 0,
            'cookie_httponly' => 1,
            'cookie_secure' => Essential::getHelper()->is_https(),
            'cookie_samesite' => 'strict',
            'use_cookies' => 1,
            'use_strict_mode' => 1,
            'hash_function' => "sha256",
        ];
    }


    private function preDefineSessionDBStorageOptions()
    {

        return [
            'db_username'=> Tinkle::$app->config['db']['user'],
            'db_password'=> Tinkle::$app->config['db']['password'],
//            'db_connection_options'=> '',

        ];

    }







    // Class End


}