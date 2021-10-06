<?php


    $global = $_ENV['DEV_MODE'];
    $data['trace'] = explode('#',$data['trace']);

$myFile = $data['file'];
$lines = file($myFile);//file in to an array
$count = count($lines);
$lower = $data['line']-5;
$higher = $data['line']+5;

$data['display'] = '';
    if($data['line']+5 < $count)
    {
        $lpart='';
        $mpart='';
        $hpart='';
        foreach ($lines as $key => $line)
        {
            if(!empty($line))
            {
                if($key > $lower && $key <$data['line'])
                {
                    $lpart .= "<b>$key :</b><i style='color:yellow;'>$line</i>" . "<br>";
                }

                if($key === $data['line'])
                {
                    $mpart = "<b>$key :</b><b style='color: red'>$line</b>" . "<br>";
                }
                if( $key > $data['line'] && $key < $higher)
                {
                    $hpart = "<b>$key :</b><i style='color:yellow;'>$line</i>" . "<br>";
                }
            }
        }

        $data['display'] = $lpart.$mpart.$hpart;

    }else{
        $data['display'] = $lines[$data['line']];
    }








?>
<style>
    div.tinkle_exception_preview{
        background-color: black;
        color: yellow;
        margin: 5px;
        padding: 5px;
    }



div.tinkle_exception {
    font-family: "Times New Roman", Times, serif;
    text-indent: 10px;

    border: 5px inset red;
    background-color: lightpink;
    -webkit-animation-name: error_border; /* Safari 4.0 - 8.0 */
    -webkit-animation-duration: 20s; /* Safari 4.0 - 8.0 */
    animation-name: error_border;
    animation-duration: 20s;

}

/* Standard syntax */
@keyframes error_border {
    0%   {border-color: red;}
    10%   {border-color: orangered;}
    20%   {border-color: indianred;}
    30%   {border-color: hotpink;}
    40%  {border-color: deeppink;}
    50%  {border-color: blueviolet;}
    65%  {border-color: royalblue;}
    80%  {border-color: blue;}
    90% {border-color: green;}
    100% {border-color: black;}
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
ul{
    list-style-type: none;
}

</style>

<div class="tinkle_exception">
    <h3 style="color: red">Something Wrong Happen!</h3>


   <div class="">
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
               <td><?php echo $data['code']; ?></td>

           </tr>
           <?php
           if($global){

           ?>
           <tr>
               <td>Line : </td>
               <td> <?php echo $data['line']; ?></td>
           </tr>

           <tr>
               <td>File : </td>
               <td> <?php echo $data['file'];?> </td>
           </tr>
           <?php
           }
           ?>

           </tbody>
       </table>
   </div>

    <?php
    if($global)
    {
    ?>

    <div style='background-color: darkgray; padding: 1px; margin: 2px; color: black'>
            <h3>Traces :-</h3>
            <?php
            echo "<ul>";
            foreach ($data['trace'] as $trace)
            {
                echo "<li >$trace</li>";
            }
            echo "</ul>";

            ?>

    </div>

    <div class="tinkle_exception_preview">
        <h3>Preview :-</h3>
        <code style="margin: 2px; padding: 2px;">

            <?php echo $data['display'];

            ?>

        </code>



    </div>


    <?php
     }
    ?>



</div>

