<!--====== Start Header ======-->
<header class="header-area" data-aos="fade-down">
    <div class="nav-pattern"></div>
    <!-- Start mobile menu -->
    <div class="mobile-menu">
        <div class="container">
            <div class="mobile-menu-wrapper"></div>
        </div>
    </div>
    <!-- End mobile menu -->

    <div class="main-responsive-nav">
        <div class="container">
            <!-- Mobile Logo -->
            <div class="logo">

                <a href=""><img src="{{ asset('assets/front/img/') }}"
                        class="img-fluid" alt=""></a>
            </div>
            <!-- Menu toggle button -->
            <button class="menu-toggler" type="button">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </div>

    <div class="main-navbar">
        <div class="container">
            <nav class="navbar navbar-expand-lg">
                
            
                <!-- Logo -->
                <a href="{{ url('/') }}">
                    <img src="{{ asset('front-assets/images/logo.png') }}" class="mobile-logo logo-1" alt="logo" style="width: 200px;">
                </a>
              
                <!-- Navigation items -->
                <div class="collapse navbar-collapse">
                    <ul id="mainMenu" class="navbar-nav mobile-item">
                        
                    {{--                      
                        <li class="nav-item">
                            <a class="nav-link toggle" href="link2.html" target="_self">Link 2 <i class="fal fa-plus"></i></a>
                            <ul class="menu-dropdown">
                                <li class="nav-item">
                                    <a class="nav-link" href="sublink1.html" target="_self">Sub Link 1</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="sublink2.html" target="_self">Sub Link 2</a>
                                </li>
                            </ul>
                        </li> --}}
                        
                      
                       
                     
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_self">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_self">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_self">Temples</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_self">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#" target="_self">Contact Us</a>
                        </li>
                     
                      
                    </ul>
                </div>
               
                <div class="more-option mobile-item">
                    <div class="item">
                        <a href="{{route('templelogin')}}" target="_blank" class="btn btn-md btn-primary" title="Login">Temple Login</a>
                        <a href="{{route('temple-register')}}" class="btn btn-md btn-primary" title="Dashboard">Temple Register</a>
                    </div>
                </div>
                
            
            </nav>
            
            
        </div>
    </div>
</header>
<!--====== End Header ======-->