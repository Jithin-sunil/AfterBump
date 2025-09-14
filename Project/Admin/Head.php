<?php
include('SessionValidation.php');

?>  
  <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modernize Free</title>
        <link rel="shortcut icon" type="image/png" href="../Assets/Templates/Admin/assets/images/logos/favicon.png" />
        <link rel="stylesheet" href="../Assets/Templates/Admin/assets/css/styles.min.css" />
    </head>

    <body>
        <!--  Body Wrapper -->
        <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
            data-sidebar-position="fixed" data-header-position="fixed">
            <!-- Sidebar Start -->
            <aside class="left-sidebar">
                <!-- Sidebar scroll-->
                <div>
                    <div class="brand-logo d-flex align-items-center justify-content-between">
                        <a href="./index.html" class="text-nowrap logo-img">
                            <img src="../Assets/Templates/Admin/assets/images/logos/dark-logo.svg" width="180" alt="" />
                        </a>
                        <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                            <i class="ti ti-x fs-8"></i>
                        </div>
                    </div>
                    <!-- Sidebar navigation-->
                    <!-- Sidebar navigation-->
                    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
                        <ul id="sidebarnav">
                            <li class="nav-small-cap">
                                <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
                                <span class="hide-menu">Admin Menu</span>
                            </li>

                            <!-- Home -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="HomePage.php" aria-expanded="false">
                                    <span><i class="ti ti-layout-dashboard"></i></span>
                                    <span class="hide-menu">Home</span>
                                </a>
                            </li>


                            <!-- District -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="District.php" aria-expanded="false">
                                    <span><i class="ti ti-map"></i></span>
                                    <span class="hide-menu">District</span>
                                </a>
                            </li>

                            <!-- Place -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="Place.php" aria-expanded="false">
                                    <span><i class="ti ti-map-pin"></i></span>
                                    <span class="hide-menu">Place</span>
                                </a>
                            </li>

                            <!-- Brand -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="Brand.php" aria-expanded="false">
                                    <span><i class="ti ti-tag"></i></span>
                                    <span class="hide-menu">Brand</span>
                                </a>
                            </li>

                            <!-- Category -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="Category.php" aria-expanded="false">
                                    <span><i class="ti ti-folder"></i></span>
                                    <span class="hide-menu">Category</span>
                                </a>
                            </li>

                            <!-- Service Type -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="ServiceType.php" aria-expanded="false">
                                    <span><i class="ti ti-briefcase"></i></span>
                                    <span class="hide-menu">Service Type</span>
                                </a>
                            </li>

                            <!-- Seller Verification -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="SellerVerification.php" aria-expanded="false">
                                    <span><i class="ti ti-check"></i></span>
                                    <span class="hide-menu">Seller Verification</span>
                                </a>
                            </li>

                            <!-- Delivery Boy Verification -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="DeliveryBoyVerification.php" aria-expanded="false">
                                    <span><i class="ti ti-motorbike"></i></span>
                                    <span class="hide-menu">Delivery Boy Verification</span>
                                </a>
                            </li>

                            <!-- User List -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="UserList.php" aria-expanded="false">
                                    <span><i class="ti ti-users"></i></span>
                                    <span class="hide-menu">User List</span>
                                </a>
                            </li>

                            <!-- Complaints -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="ViewComplaint.php" aria-expanded="false">
                                    <span><i class="ti ti-alert-circle"></i></span>
                                    <span class="hide-menu">View Complaints</span>
                                </a>
                            </li>

                        

                            <!-- Feedback -->
                            <li class="sidebar-item">
                                <a class="sidebar-link" href="ViewFeedback.php" aria-expanded="false">
                                    <span><i class="ti ti-star"></i></span>
                                    <span class="hide-menu">View Feedback</span>
                                </a>
                            </li>

                           
                        </ul>
                    </nav>


                    <!-- End Sidebar navigation -->
                </div>
                <!-- End Sidebar scroll-->
            </aside>
            <!--  Sidebar End -->
            <!--  Main wrapper -->
            <div class="body-wrapper">
                <!--  Header Start -->
                <header class="app-header">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <ul class="navbar-nav">
                            <li class="nav-item d-block d-xl-none">
                                <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse"
                                    href="javascript:void(0)">
                                    <i class="ti ti-menu-2"></i>
                                </a>
                            </li>

                        </ul>
                        <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                                <li class="nav-item dropdown">
                                    <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="../Assets/Templates/Admin/assets/images/profile/user-1.jpg" alt=""
                                            width="35" height="35" class="rounded-circle">
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up"
                                        aria-labelledby="drop2">
                                        <div class="message-body">

                                            <a href="Logout.php"
                                                class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </header>
                <!--  Header End -->
                <div class="container-fluid">