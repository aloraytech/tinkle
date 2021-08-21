    {{extend('layout/bootstrap')}}

    {{include('components/navigation')}}
    <!--    MAIN AREA START -->
    <main class="bg-primary">
       {{include('components/sidebar')}}

            <div class="card container-fluid shadow-lg">
                    <!-- Page Header -->
                    <div class="card-header inline ">
                        <!--   Progress Bar -->
                        <div class="progress" style="height: 2px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--   ./Progress Bar -->
                            <!-- Page Title-->
                        <div class="float-left  d-inline-block">
                            <b class="display-5">Hello Page</b>
                        </div>
                            <!-- ./Page Title-->
                            <!-- Page Breadcrumb -->
                        <div class="float-end d-inline-block ">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div>
                        <!-- ./Page Breadcrumb -->
                    </div>
                    <!-- ./Page Header -->
                    <div class="card-body shadow-lg">
                        <div class="container scrollarea ">
                        <!-- MAIN PAGE CONTENT START -->

                           <div class="row">


                               <div class="card col-lg-3 col-sm-12 bg-dark text-white">
                                   <img src="{{assets('resources/upload/img2.jpg')}}" class="card-img" alt="...">
                                   <div class="card-img-overlay">
                                       <h5 class="card-title">Card title</h5>
                                       <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                                       <p class="card-text">Last updated 3 mins ago</p>
                                   </div>
                               </div>







                           </div>






                            <!-- MAIN PAGE CONTENT END -->
                        </div>
                    </div>

                    <div class="card-footer">

                        <footer class="d-flex flex-wrap justify-content-between align-items-center py-1 my-1 border-top">
                            <div class="col-md-4 d-flex align-items-center">
                                <a href="https://getbootstrap.com/" class="mb-3 me-2 mb-md-0 text-muted text-decoration-none lh-1">
                                    <svg class="bi" width="30" height="24"><use xlink:href="#bootstrap"></use></svg>
                                </a>
                                <span class="text-muted">© 2021 Company, Inc</span>
                            </div>

                            <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
                                <li class="ms-3"><a class="text-muted" href="https://getbootstrap.com/docs/5.1/examples/footers/#"><svg class="bi" width="24" height="24"><use xlink:href="#twitter"></use></svg></a></li>
                                <li class="ms-3"><a class="text-muted" href="https://getbootstrap.com/docs/5.1/examples/footers/#"><svg class="bi" width="24" height="24"><use xlink:href="#instagram"></use></svg></a></li>
                                <li class="ms-3"><a class="text-muted" href="https://getbootstrap.com/docs/5.1/examples/footers/#"><svg class="bi" width="24" height="24"><use xlink:href="#facebook"></use></svg></a></li>
                            </ul>
                        </footer>
                    </div>
            </div>

    </main>








    <!--Fixed Area-->
    {{include('components/offCanvas')}}


    <!--    DISPLAY TOOLTIP FOR SIDEBAR MENU -->
    <div class="tooltip fade show bs-tooltip-end" role="tooltip" id="tooltip370644" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(680px, 145px);" data-popper-placement="right">
        <!--    ./DISPLAY TOOLTIP FOR SIDEBAR MENU ./-->

