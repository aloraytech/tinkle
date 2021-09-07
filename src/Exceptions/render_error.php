<?php

if(!$_SERVER['DEV_MODE'])
{

    $data['line'] = ' -- No Line Found --';
    $data['file'] = ' -- No File Found --';
    $data['trace'] = '-- No Trace Found --';
}

header_remove('X-Powered-By');
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            background-color: black;
            color: white;
            font-size: larger;
        }
       div {
           margin: 2rem;
           padding: 2rem;
           max-height: 90%;
           max-width: 90%;
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

</head>
<body>

    <h2 align="center"> Something Wrong Happen </h2>
    <?php echo "<h1 align='center'> ".$data['code']."</h1>";  ?>

    <a href="/" style="background-color: black;color: white;"> <h3 align="center">Back To Home</h3> </a>


        <div>
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
                    <td><?php echo $data['message']; ?></td>

                </tr>
                <tr>

                    <td>Code : </td>
                    <td> <?php echo $data['code']; ?> </td>

                </tr>
                <tr>

                    <td>Line : </td>
                    <td> <?php echo $data['line']; ?> </td>
                </tr>

                <tr>

                    <td>File : </td>
                    <td> <?php echo $data['file']; ?> </td>
                </tr>
                </tbody>
            </table>

                <?php
                if($_SERVER['DEV_MODE'])
                {
                    echo '<div style="scroll-behavior: auto; border: black 4px solid">';
                    echo "<h2 align='center'>-: Traces :-</h2><pre>";
                    print_r($data['trace']);
                    echo "</pre>";
                    echo "</div>";
                }

                ?>


        </div>



</body>
</html>
