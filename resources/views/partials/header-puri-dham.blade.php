
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


<header class="header-area">
    <div class="header-content">
      <div class="logo">
        <a href="#">
          <img src="{{ asset('website/logo.png') }}" alt="logo">
        </a>
      </div>
  
      <!-- Desktop Menu -->
      <nav class="nav-menu desktop-menu">
        <a href="#">Nitis</a>
        <a href="#services">Services</a>
        <a href="#temple-slider">Nearby Temples</a>
        <a href="#convience">Conveniences</a>
        <a href="#panji">Panji</a>
      </nav>
  
      <!-- Hamburger Icon -->
      <div class="hamburger-icon" onclick="toggleMobileMenu(this)">
        <div class="hamburger-menu">
          <ion-icon name="menu-outline" style="height: 35px;width:45px"></ion-icon>
        </div>
      </div>
    </div>
  
    <!-- Mobile Nav -->
    <nav class="nav-menu mobile-nav" id="mobileNav">
      <div class="nav-close" onclick="closeMobileMenu()"><i class="fa fa-times"></i></div>
      <ul>
        <li><a href="#">Nitis</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#temple-slider">Nearby Temples</a></li>
        <li><a href="#convience">Conveniences</a></li>
        <li><a href="#panji">Panji</a></li>
      </ul>
    </nav>
  </header>