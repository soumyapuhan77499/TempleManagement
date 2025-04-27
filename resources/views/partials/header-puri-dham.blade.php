<header class="header-area">
    <div class="header-content">
        <div class="logo">
            <img src="{{ asset('website/logo.png') }}" alt="logo">
        </div>

        <!-- Desktop Menu -->
        <nav class="nav-menu">
            <a href="#">Nitis</a>
            <span class="separator">SM <a href="#" class="live-badges"><i class="fa fa-bolt"></i> Live</a></span>
            <a href="#">Services</a>
            <a href="#">Nearby Temples</a>
            <a href="#">Conveniences</a>
            <a href="#">Temple Information</a>
        </nav>

        <!-- Hamburger Icon (Mobile) -->
        <div class="hamburger-icon" onclick="openMobileMenu()">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</header>

<!-- Mobile Nav Wrapper -->
<div id="mobileNavWrapper" class="mobile-nav-wrapper">
    <!-- Mobile Nav -->
    <nav id="mobileNav" class="mobile-nav">
        
        <!-- CLOSE BUTTON -->
        <div class="nav-close" onclick="closeMobileMenu()">
            <i class="fas fa-times"></i> <!-- This is the Close "X" icon -->
        </div>

        <ul>
            <li><a href="#">Nitis</a></li>
            <li><a href="#">SM <span class="live-badges"><i class="fa fa-bolt"></i> Live</span></a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Nearby Temples</a></li>
            <li><a href="#">Conveniences</a></li>
            <li><a href="#">Temple Information</a></li>
        </ul>
    </nav>
</div>

<script>
    function openMobileMenu() {
        document.getElementById('mobileNavWrapper').classList.add('active');
        document.getElementById('mobileNav').classList.add('active');
    }

    function closeMobileMenu() {
        document.getElementById('mobileNavWrapper').classList.remove('active');
        document.getElementById('mobileNav').classList.remove('active');
    }
</script>

