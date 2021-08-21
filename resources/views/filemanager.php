{{extend('layout/bootstrap')}}
<?php

?>


    <div class="card col-12">
        <div class="card-header"><?php echo $title??''; ?></div>

        <div class="card-body">


            <div class="row">


                <div class="col-3">


                </div>


                <div class="col-9"></div>


            </div>


        </div>

    </div>




<script>
    $("button").click(function(){
        $.post("demo_test_post.asp",
            {
                name: "Donald Duck",
                city: "Duckburg"
            },
            function(data, status){
                alert("Data: " + data + "\nStatus: " + status);
            });
    });
</script>