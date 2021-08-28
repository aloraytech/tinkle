<?php


namespace Tinkle\Exceptions;


use Tinkle\Exceptions\CoreException;
use Tinkle\Tinkle;

/**
 * Class Display
 * @package Tinkle\Exceptions
 */
class Display extends CoreException
{


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






    public function ErrorToException()
    {

        parse_str($this->message,$var);
        $data = [
            'message' => $var['_msg'],
            'code' => $var['_severity'],
            'line' => $var['_line'],
            'file' => $var['_file'],
            'trace' => $this->getTrace()
        ];

        $this->Show($data);
        die;
    }


    public function CliError()
    {
        echo "\e[92m  Exception Found : "."\n".
                "message :".$this->message ."\n".
                "code : ". $this->code ."\n".
                "line :". $this->line ."\n".
                "file :". $this->file."\n".
                "\n\e[0m";

        die;
    }












    public function Suggession (){

        echo " Exception Found : <br>
                message : $this->message <br>
                code : $this->code <br>
                line : $this->line <br>
                file : $this->file <br>
                
                ";

        die;

    }


    public function Render (){

        $data = [
            'message' => $this->message,
            'code' => $this->code,
            'line' => $this->line,
            'file' => $this->file,
            'trace' => $this->getTrace()
        ];

        $this->Show($data);
        die;

    }


    public function ErrorInFormat (){

        echo " Exception Found : <br>
                message : $this->message <br>
                code : $this->code <br>
                line : $this->line <br>
                file : $this->file <br>
                
                ";

        die;

    }


    public function ConnectionFailed (){

        echo " Exception Found : <br>
                message : $this->message <br>
                code : $this->code <br>
                line : $this->line <br>
                file : $this->file <br>
                
                ";

        die;

    }


    public function WrongTypeParameter (){

        echo " Exception Found : <br>
                message : $this->message <br>
                code : $this->code <br>
                line : $this->line <br>
                file : $this->file <br>
                
                ";

        die;

    }








    protected function Show(array $data)
    {
        if(is_array($data))
        {
            http_response_code($data['code']);
            $this->layout($this->layoutBody($data));
        }

    }


    protected function Layout($body)
    {
            $layout = '
            
                <!doctype html>
                    <html lang="en">
                      <head>
                        <!-- Required meta tags -->
                        <meta charset="utf-8">
                        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
                    
                    <style>
                        table, th, td {
                          border: 1px solid black;
                          border-collapse: collapse;
                        }
                        th, td {
                          padding: 5px;
                        }
                        th {
                          text-align: left;
                        }
                    </style>
                    
                    
                        <!-- Bootstrap CSS -->
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
                    
                        <title>Error::</title>
                      </head>
                      <body>
                        <h1>Error::</h1>
                        '. $body.'
                    
                        <!-- Optional JavaScript -->
                        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
                        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
                        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
                      </body>
                    </html>
            
            
            ';

            echo $layout;
    }



    protected function layoutBody($data)
    {
        return '
        
                <table class="table table-striped table-dark">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">First</th>
                          <th scope="col">Last</th>
                          
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Message : </td>
                          <td>'. $data["message"].'</td>
                          
                        </tr>
                        <tr>
                          <th scope="row">2</th>
                          <td>Code : </td>
                          <td>'. $data["code"].'</td>
                          
                        </tr>
                        <tr>
                          <th scope="row">3</th>
                          <td>Line : </td>
                          <td>'. $data["line"].'</td>
                        </tr>
                        
                        <tr>
                          <th scope="row">4</th>
                          <td>File : </td>
                          <td>'. $data["file"].'</td>
                        </tr>
                      </tbody>
                </table>
        
        
        
        ';
    }







}