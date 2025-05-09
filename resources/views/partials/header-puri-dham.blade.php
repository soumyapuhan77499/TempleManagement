<header class="header-area">
    <div class="header-content">
        <div class="logo">
            <a href="">
                <img src="{{ asset('website/logo.png') }}" alt="logo">
            </a>
        </div>

        <!-- Desktop Menu (hidden on mobile) -->
        <nav class="nav-menu desktop-menu">
            <a href="#">Nitis</a>
            <a href="#services">Services</a>
            <a href="#temple-slider">Nearby Temples</a>
            <a href="#convience">Conveniences</a>
            <a href="#panji">Panji</a>
        </nav>

        <!-- Hamburger Icon (Mobile Only) -->
        <div class="hamburger-icon" onclick="openMobileMenu()">
            <div class="hamburger-menu">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <!-- Mobile Nav Menu -->
    <nav class="nav-menu mobile-nav" id="mobileNav">
        <div class="nav-close" onclick="closeMobileMenu()">
            <i class="fa fa-times"></i>
        </div>
        <ul>
            <li><a href="#">Nitis</a></li>
            <li><a href="#services">Services</a></li>
            <li><a href="#temple-slider">Nearby Temples</a></li>
            <li><a href="#convience">Conveniences</a></li>
            <li><a href="#panji">Panji</a></li>
        </ul>
    </nav>
</header>
