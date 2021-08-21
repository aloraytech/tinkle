<?php


namespace tinkle\framework\Exceptions;


use tinkle\framework\Exceptions\CoreException;

/**
 * Class Display
 * @package tinkle\framework\Exceptions
 */
class Display extends CoreException
{


    public function ErrorToException()
    {
        $_msg='';
        $_severity=500;
        $_line='';
        $_file='';
        parse_str($this->message);
        $data = [
            'message' => $_msg,
            'code' => $_severity,
            'line' => $_line,
            'file' => $_file,
            'trace' => $this->getTrace()
        ];

        $this->Show($data);
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