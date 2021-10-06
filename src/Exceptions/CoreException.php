<?php

namespace Tinkle\Exceptions;

use Tinkle\interfaces\ExceptionInterface as IException;
use \Exception;
use Tinkle\Response;
use Tinkle\Router;
use Tinkle\Tinkle;

//extends Exception implements IException

/**
 * Class CoreException
 * @package Tinkle\Exceptions
 */
abstract class CoreException extends Exception implements IException
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown



    public const HTTP_USE_PROXY = 305;
    public const HTTP_RESERVED = 306;
    public const HTTP_BAD_REQUEST = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_PAYMENT_REQUIRED = 402;
    public const HTTP_FORBIDDEN = 403;
    public const HTTP_NOT_FOUND = 404;
    public const HTTP_METHOD_NOT_ALLOWED = 405;
    public const HTTP_PROXY_AUTHENTICATION_REQUIRED = 407;
    public const HTTP_REQUEST_TIMEOUT = 408;
    public const HTTP_REQUEST_URI_TOO_LONG = 414;
    public const HTTP_UNSUPPORTED_MEDIA_TYPE = 415;
    public const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = 416;
    public const HTTP_EXPECTATION_FAILED = 417;

    public const HTTP_LOCKED = 423;                                                      // RFC4918
    public const HTTP_UPGRADE_REQUIRED = 426;                                            // RFC2817
    public const HTTP_TOO_MANY_REQUESTS = 429;                                           // RFC6585
    public const HTTP_REQUEST_HEADER_FIELDS_TOO_LARGE = 431;                             // RFC6585
    public const HTTP_INTERNAL_SERVER_ERROR = 500;
    public const HTTP_NOT_IMPLEMENTED = 501;
    public const HTTP_BAD_GATEWAY = 502;
    public const HTTP_SERVICE_UNAVAILABLE = 503;
    public const HTTP_GATEWAY_TIMEOUT = 504;
    public const HTTP_VERSION_NOT_SUPPORTED = 505;
    public const HTTP_INSUFFICIENT_STORAGE = 507;                                        // RFC4918
    public const HTTP_LOOP_DETECTED = 508;                                               // RFC5842
    public const HTTP_NETWORK_AUTHENTICATION_REQUIRED = 511;

    private static DeprecationHandler $deprecationHandler;

    /**
     * CoreException constructor.
     * @param null $message
     * @param int $code
     */
    public function __construct($message = null, $code = 0)
    {
        self::$deprecationHandler = new DeprecationHandler($message, $code);
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        if(self::$deprecationHandler->is_deprecated())
        {
            self::$deprecationHandler->call_deprecated();
        }
        parent::__construct($message, $code);


    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
            . "{$this->getTraceAsString()}";
    }












    protected function output(array $data=[],bool $display=true, string $header='',string $middle='',string $footer='')
    {
        if(is_array($data))
        {
            if(is_string($data['code']))
            {
                http_response_code(503);
            }else{
                http_response_code($data['code']);
            }



            $data['code'] = $this->codeToText($data['code']) ?? $data['code'];
            $data['trace'] = $this->getTraceAsString() ?? $data['trace'];
//            extract($data);
//            echo "<pre>";
//            print_r($data);

            ob_start();
//            $output = file_get_contents(__DIR__."/render_error.php");
//            echo $output;
            require_once __DIR__."/error_template.php";
            ob_flush();

        }




    }





    /**
     * @param bool $display
     * @param string $header
     * @param string $middle
     * @param string $footer
     */
    final protected function RenderException (bool $display=true,string $header='',string $middle='',string $footer=''){

        if(!$display)
        {

            ob_get_clean();
        }

        if (PHP_SAPI === 'cli')
        {

            echo "\e[92m ** WARNING - Error Found\n\e[0m";
            echo $header;
            echo "Message : ".$this->message."\n";
            echo "Code : " . $this->codeToText($this->code) . "\n";
            echo "Line : ". $this->line . "\n";
            echo "File : ". $this->file . "\n";
            echo $middle;
            echo "Trace : " . $this->getTraceAsString() . "\n\n";
            echo $footer;



        }else{
            $data = [
                'message' => $this->message,
                'code' => $this->code ?? $this->getCode(),
                'line' => $this->line,
                'file' => $this->file,
                'trace' => $this->getTraceAsString()
            ];
            //ob_get_clean();
            $this->output($data,$display,$header,$middle,$footer);
        }

        if(!$display)
        {

            die(503);
        }




    }













    protected function codeToText(int|string $code)
    {
        if(is_int($code) || is_integer($code))
        {
            if ($code !== NULL) {

                switch ($code) {
                    case 0:
                        $text = 'Fatal Error';
                        break;
                    case 1:
                        $text = 'Fatal Runtime Error';
                        break;
                    case 2:
                        $text = 'Warning';
                        break;
                    case 4:
                        $text = 'Parse Error';
                        break;
                    case 8:
                        $text = 'Notice';
                        break;
                    case 16:
                        $text = 'Fatal Core Error';
                        break;
                    case 32:
                        $text = 'Fatal Core Warning';
                        break;
                    case 64:
                        $text = 'Compile Error';
                        break;
                    case 128:
                        $text = 'Compile Warning';
                        break;
                    case 256:
                        $text = 'User Generated Error';
                        break;
                    case 512:
                        $text = 'User Generated Warning';
                        break;
                    case 1024:
                        $text = 'User Notice';
                        break;
                    case 2048:
                        $text = 'Strict Error';
                        break;
                    case 4096:
                        $text = 'Catchable Fatal Error';
                        break;
                    case 8192:
                        $text = 'Notice For Deprecation';
                        break;
                    case 16384:
                        $text = 'Warning For Deprecation';
                        break;
                    case 32767:
                        $text = 'Errors';
                        break;

                    case 100:
                        $text = 'Continue';
                        break;
                    case 101:
                        $text = 'Switching Protocols';
                        break;
                    case 200:
                        $text = 'OK';
                        break;
                    case 201:
                        $text = 'Created';
                        break;
                    case 202:
                        $text = 'Accepted';
                        break;
                    case 203:
                        $text = 'Non-Authoritative Information';
                        break;
                    case 204:
                        $text = 'No Content';
                        break;
                    case 205:
                        $text = 'Reset Content';
                        break;
                    case 206:
                        $text = 'Partial Content';
                        break;
                    case 300:
                        $text = 'Multiple Choices';
                        break;
                    case 301:
                        $text = 'Moved Permanently';
                        break;
                    case 302:
                        $text = 'Moved Temporarily';
                        break;
                    case 303:
                        $text = 'See Other';
                        break;
                    case 304:
                        $text = 'Not Modified';
                        break;
                    case 305:
                        $text = 'Use Proxy';
                        break;
                    case 400:
                        $text = 'Bad Request';
                        break;
                    case 401:
                        $text = 'Unauthorized';
                        break;
                    case 402:
                        $text = 'Payment Required';
                        break;
                    case 403:
                        $text = 'Forbidden';
                        break;
                    case 404:
                        $text = 'Not Found';
                        break;
                    case 405:
                        $text = 'Method Not Allowed';
                        break;
                    case 406:
                        $text = 'Not Acceptable';
                        break;
                    case 407:
                        $text = 'Proxy Authentication Required';
                        break;
                    case 408:
                        $text = 'Request Time-out';
                        break;
                    case 409:
                        $text = 'Conflict';
                        break;
                    case 410:
                        $text = 'Gone';
                        break;
                    case 411:
                        $text = 'Length Required';
                        break;
                    case 412:
                        $text = 'Precondition Failed';
                        break;
                    case 413:
                        $text = 'Request Entity Too Large';
                        break;
                    case 414:
                        $text = 'Request-URI Too Large';
                        break;
                    case 415:
                        $text = 'Unsupported Media Type';
                        break;
                    case 500:
                        $text = 'Internal Server Error';
                        break;
                    case 501:
                        $text = 'Not Implemented';
                        break;
                    case 502:
                        $text = 'Bad Gateway';
                        break;
                    case 503:
                        $text = 'Service Unavailable';
                        break;
                    case 504:
                        $text = 'Gateway Time-out';
                        break;
                    case 505:
                        $text = 'HTTP Version not supported';
                        break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                        break;
                }
                return $text;
            }
        }else{
            return htmlentities($code);
        }
    }



    // Class End
}