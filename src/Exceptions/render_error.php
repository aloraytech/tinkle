<?php
header_remove('X-Powered-By');

if(!$_SERVER['DEV_MODE'])
{
    $DisplayFile='';
    $data['line'] = ' -- Protected --';
    $data['file'] = ' -- Protected --';
    $data['trace'] = '-- Protected --';
}

?>

<?php

    if( isset($display) && $display ===false)
    {
    $titleBlock = $title ?? $_SERVER['HTTP_HOST'].'|Exception Found!' ;
    }else{
    $titleBlock = $_SERVER['HTTP_HOST'].'|Exception Found!';
    }
    $titleBlock = '<title>'.$titleBlock.'</title>';

    $cssBlock = '
        <style>
//        body{
//            background-color: black;
//            color: white;
//            font-size: larger;
//        }
        div.exception {
       // background-color: black;
            color: white;
            font-size: larger;

        }
       div.error-div {
           
//           margin: 3rem;
//           padding: 3rem;
//           max-height: 90%;
//           max-width: 90%;
           /*background-color: #ba8b00;*/
           background-color: red;
           -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
           -webkit-animation-duration: 20s; /* Safari 4.0 - 8.0 */
           animation-name: example;
           animation-duration: 20s;
       }
        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes example {
            0%   {background-color: red;}
            10%   {background-color: orangered;}
            20%   {background-color: indianred;}
            30%   {background-color: hotpink;}
            40%  {background-color: deeppink;}
            50%  {background-color: blueviolet;}
            65%  {background-color: royalblue;}
            80%  {background-color: blue;}
            90% {background-color: green;}
            100% {background-color: black;}
        }

        /* Standard syntax */
        @keyframes example {
            0%   {background-color: red;}
            10%   {background-color: orangered;}
            20%   {background-color: indianred;}
            30%   {background-color: hotpink;}
            40%  {background-color: deeppink;}
            50%  {background-color: blueviolet;}
            65%  {background-color: royalblue;}
            80%  {background-color: blue;}
            90% {background-color: green;}
            100% {background-color: black;}
        }
        table, th, td {
            /*border: 1px solid black;*/
            border-collapse: collapse;
        }
        th{
            padding: 5px;
            margin: 5px;
            max-width: 30%;
        }
        td{
            padding: 8px;
            margin: 15px;
            max-width: 70%;
        }
        th {
            text-align: left;
        }
    </style>
    ';

$headerBlock = '
        
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    '.$titleBlock.$cssBlock.'
    

</head>
<body>

' ;


$footerBlock = '</body></html>';

$header = $header??'Something wrong happen..';
$middle = $middle ?? '';
$footer = $footer??'';
$message = $data['message'] ?? '--Not Recoverable--';
$code = $data['code'] ?? '--Not Recoverable--';
$file = $data['file'] ?? '--Not Recoverable--';
$line = $data['line'] ?? '--Not Recoverable--';
$trace = $data['trace']?? '--Not Recoverable--';
if(!$_SERVER['DEV_MODE']) {

    $trace = '<div style="scroll-behavior: auto; border: black 4px solid"><h2 align="center">-: Traces :-</h2>' . $trace . '</div>';
}else{
    $trace='';
}

if($display)
{
    $headerBlock =$cssBlock;
    $footerBlock='';
}
echo $headerBlock.'
           <div class="exception">
         <div class="error-div">
            <h2 align="center">'.$header.'</h2> <h1 align="center"> '.$code.'</h1>
            <p align="center">'.$middle.'</p>
            <a href="/" style="background-color: black;color: white;"> <h3 align="center">Back To Home</h3> </a>


        <div class="error-div">
            <table class="table table-striped table-dark">
                <thead>
                <tr>

                    <th scope="col"><u>Subject</u></th>
                    <th scope="col"><u>Details</u></th>

                </tr>
                </thead>
                <tbody>
                <tr>

                    <td>Message : </td>
                    <td>'.$message.'</td>

                </tr>
                <tr>

                    <td>Code : </td>
                    <td>'.$code.'</td>

                </tr>
                <tr>

                    <td>Line : </td>
                    <td> '.$line.'</td>
                </tr>

                <tr>

                    <td>File : </td>
                    <td>'.$file.'</td>
                </tr>
                </tbody>
            </table>
        </div>
        '.$trace.' <h5 align="center">'.$footer.'</h5>
    </div>
    </div>

'.$footerBlock;
