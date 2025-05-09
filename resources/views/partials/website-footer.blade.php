<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo-section">
            <img src="{{ asset('website/logo.png') }}" alt="logo" class="footer-logo" />
            <div class="footer-title">
                <h2>Shree</h2>
                <h2>Jagannatha</h2>
                <h2>Dham</h2>
            </div>
        </div>

        <div class="footer-links">
            <div>
                <h3>Temple Information</h3>
                <ul>
                    <li><a href="{{ url('/online-donation') }}">Online Donation</a></li>
                    <li><a href="{{ url('/hundi-collection') }}">Hundi Collection</a></li>
                </ul>
            </div>
            <div>
                <h3>Quick Services</h3>
                <ul>
                    <li><a href="{{ url('/darshan-timeline') }}">Darshan</a></li>
                    <li><a href="{{ url('/maha-prasad') }}">Mahaprasad</a></li>
                    <li><a href="{{ url('/view-panji-details') }}">Panji</a></li>
                    <li><a href="{{ url('/view-festival-details') }}">Temple Festival</a></li>
                </ul>
            </div>
            <div>
                <h3>Conveniences</h3>
                <ul>
                    <li><a href="{{ url('/services/drinking_water') }}">Drinking Water</a></li>
                    <li><a href="{{ url('/services-abled') }}">Special Abled Person</a></li>
                    <li><a href="#">Route Map</a></li>
                    <li><a href="{{ url('/services/lost_and_found_booth') }}">Lost And Found</a></li>
                    <li><a href="{{ url('/services/toilet') }}">Toilet</a></li>
                    <li><a href="{{ url('/services/beach') }}">Beaches</a></li>
                    <li><a href="{{ url('/services/life_guard_booth') }}">Life Guards</a></li>

                </ul>
            </div>
            <div>
                <h3>Nearby Temples</h3>
                <ul>
                    <li><a href="#">Link Name</a></li>
                    <li><a href="#">Link Name</a></li>
                    <li><a href="#">Link Name</a></li>
                    <li><a href="#">Link Name</a></li>
                    <li><a style="color: red"
                            href="https://shreejagannathadham.com/puri-website/privacy-policy">privacy policy</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <a href="https://play.google.com/store" target="_blank" class="app-button">
                    <img src="{{ asset('website/footer/google-play.png') }}" alt="Google Play">
                </a>
                <a href="https://www.apple.com/app-store/" target="_blank" class="app-button">
                    <img src="{{ asset('website/footer/apple.png') }}" alt="App Store">
                </a>
            </div>
        </div>
    </div>
</footer>

<div style="height: 80px;width: 100%; background-color: #ffae35;display: flex;align-items: center;justify-content: center;">
    <div class="text-center text-sm text-black-400 mt-10 mb-6">
        © {{ date('Y') }} Temple Management System. All rights reserved.
    </div>
</div>

<script>
    function toggleMobileMenu(el) {
      const mobileNav = document.getElementById('mobileNav');
      const icon = document.getElementById('menuToggleIcon');
  
      // Toggle menu visibility
      mobileNav.classList.toggle('active');
  
      // Toggle icon type
      const isOpen = mobileNav.classList.contains('active');
      icon.setAttribute('name', isOpen ? 'close-outline' : 'menu-outline');
    }
  
    function closeMobileMenu() {
      const mobileNav = document.getElementById('mobileNav');
      const icon = document.getElementById('menuToggleIcon');
  
      mobileNav.classList.remove('active');
      icon.setAttribute('name', 'menu-outline');
    }
  </script>
  