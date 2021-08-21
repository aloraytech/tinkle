    {{extend('layout/bootstrap')}}

    <!--    NAVIGATION START -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
        <div class="container-fluid">
    <!--        <a class="navbar-brand" href="#">Navbar</a>-->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"><span class="navbar-toggler-icon"></span></button>
            <h3 class="text-white">WEBSITE NAME</h3>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>

<!--                USER AREA-->

                <!-- Default dropstart button -->
                <div class="btn-group dropstart">

                    <a class="btn dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/mdo.png" alt="mdo" width="34" height="34" class="rounded-circle float-end">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li><a class="dropdown-item" href="#">Activities</a></li>
                        <li><a class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>


<!--                USER AREA END-->

            </div>
        </div>
    </nav>
    <!--    NAVIGATION END -->


    <!--    MAIN AREA START -->
    <main>

       {{include('components/sidebar')}}

            <div class="container-fluid shadow-lg">
                    <div class="card-header inline ">

                        <div class="progress" style="height: 1px;">
                            <div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>

                        <div class="float-left  d-inline-block">
                            <b class="display-5">Hello Page</b>
                        </div>

                        <div class="float-end d-inline-block ">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item"><a href="#">Library</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Data</li>
                                </ol>
                            </nav>
                        </div>
                    </div>

                    <div class="card-body  shadow-lg" style="min-height: 81vh">
                        <!-- MAIN PAGE CONTENT START -->

                            <div class="row">

                                <div class="card col-4">
                                    <img class="card-img-top " src="{{assets('resources/upload/$2y$10$Emm7EZRuSNklk1JdpPVXUOXbivMPOwdw72e5I6QPe..WUKWY3XgTO.jpg')}}" alt="Card image">
                                    <div class="card-img-overlay">
                                        <h4 class="card-title">John Doe</h4>
                                        <p class="card-text">Some example text.</p>
                                        <a href="#" class="btn btn-primary">See Profile</a>
                                    </div>
                                </div>


                                <div class="card" style="width: 18rem;">
                                    <img src="{{assets('resources/upload/$2y$10$Emm7EZRuSNklk1JdpPVXUOXbivMPOwdw72e5I6QPe..WUKWY3XgTO.jpg')}}" class="card-img-top rounded" alt="...">
                                    <div class="card-body">
                                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>




                            </div>



                        <!-- MAIN PAGE CONTENT END -->
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
    <!--    SIDEBAR MANAGE-->

    <!--    Off Campus Area-->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Offcanvas right</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            ...

        </div>
    </div>

    <!--    //OffCampus Area ./-->

    <!--    SIDEBAR MANAGE-->




    <!--    DISPLAY TOOLTIP FOR SIDEBAR MENU -->
    <div class="tooltip fade show bs-tooltip-end" role="tooltip" id="tooltip370644" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(680px, 145px);" data-popper-placement="right">
        <!--    ./DISPLAY TOOLTIP FOR SIDEBAR MENU ./-->

