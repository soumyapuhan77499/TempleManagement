<!-- Ionicons for Hamburger -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

<!-- HEADER -->
<header class="header-area">
    <div class="header-content">
        <!-- Logo -->
        <div class="logo">
            <a href="#">
                <img src="{{ asset('website/logo.png') }}" alt="logo">
            </a>
        </div>

        <!-- Desktop Menu -->
        <nav class="nav-menu desktop-menu">
            <ul>
                <li><a href="#">Nitis</a></li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle">Quick Services <i
                            class="fa fa-chevron-down ms-2"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ url('/darshan-timeline') }}">Darshan</a></li>
                        <li><a href="{{ url('/maha-prasad') }}">Mahaprasad</a></li>
                        <li><a href="{{ url('/view-festival-details') }}">Festival</a></li>
                        <li><a href="{{ url('/do-and-donts') }}">Do's & Don'ts</a></li>
                    </ul>
                </li>

                @php
                    use App\Models\NearByTemple;
                    $temples = NearByTemple::where('language', 'English')->get();
                @endphp

                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle">
                        Nearby Temples <i class="fa fa-chevron-down ms-2"></i>
                    </a>
                    <ul class="submenu">
                        @forelse ($temples as $temple)
                            <li>
                                <a href="{{ route('nearby-temple-view', $temple->name) }}">
                                    {{ $temple->name }}
                                </a>
                            </li>
                        @empty
                            <li><a href="#">No Temples Found</a></li>
                        @endforelse
                    </ul>
                </li>

                <li class="has-submenu">
                    <a href="javascript:void(0)" class="submenu-toggle">Conveniences <i
                            class="fa fa-chevron-down ms-2"></i></a>
                    <ul class="submenu">
                        <li><a href="{{ url('/bhaktanibas-list') }}">Bhakta Nibas</a></li>
                        <li><a href="{{ url('/parking-list') }}">Parking</a></li>
                        <li><a href="{{ url('/locker-shoe-list') }}">Locker & Shoe</a></li>
                        <li><a href="{{ url('/services/drinking_water') }}">Drinking Water</a></li>
                        <li><a href="{{ url('/services-emergency') }}">Emergency</a></li>
                        <li><a href="{{ url('/services-abled') }}">Special Abled Person</a></li>
                        <li><a href="#">Route Map</a></li>
                        <li><a href="{{ url('/services/lost_and_found_booth') }}">Lost & Found</a></li>
                        <li><a href="{{ url('/services/toilet') }}">Toilet</a></li>
                        <li><a href="{{ url('/services/beach') }}">Beaches</a></li>
                        <li><a href="{{ url('/services/life_guard_booth') }}">Life Guards</a></li>
                    </ul>
                </li>

                <li><a href="#panji">Panji</a></li>
            </ul>
        </nav>

        <!-- Hamburger Icon -->
        <div class="hamburger-icon" onclick="toggleMobileMenu(this)">
            <div class="hamburger-menu">
                <ion-icon name="menu-outline" style="height: 35px;width:45px"></ion-icon>
            </div>
        </div>
    </div>

    <!-- Mobile Nav (same submenu structure) -->
    <nav class="nav-menu mobile-nav" id="mobileNav">
        <div class="nav-close" onclick="closeMobileMenu()"><i class="fa fa-times"></i></div>
        <ul>
            <li><a href="#">Nitis</a></li>

            <li class="has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">Quick Services <i
                        class="fa fa-chevron-down ms-2"></i></a>
                <ul class="submenu" style="margin-top: 100px">
                    <li><a href="{{ url('/darshan-timeline') }}">Darshan</a></li>
                    <li><a href="{{ url('/maha-prasad') }}">Mahaprasad</a></li>
                    <li><a href="{{ url('/view-festival-details') }}">Festival</a></li>
                    <li><a href="{{ url('/do-and-donts') }}">Do's & Don'ts</a></li>
                </ul>
            </li>

            <li class="has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">Nearby Temples <i
                        class="fa fa-chevron-down ms-2"></i></a>
                <ul class="submenu" style="margin-top: 100px">
                    @foreach ($temples as $temple)
                        <li><a href="{{ route('nearby-temple-view', $temple->name) }}">{{ $temple->name }}</a></li>
                    @endforeach
                </ul>
            </li>

            <li class="has-submenu">
                <a href="javascript:void(0)" class="submenu-toggle">Conveniences <i
                        class="fa fa-chevron-down ms-2"></i></a>
                <ul class="submenu" style="margin-top: 100px">
                    <li><a href="{{ url('/bhaktanibas-list') }}">Bhakta Nibas</a></li>
                    <li><a href="{{ url('/parking-list') }}">Parking</a></li>
                    <li><a href="{{ url('/locker-shoe-list') }}">Locker & Shoe</a></li>
                    <li><a href="{{ url('/services/drinking_water') }}">Drinking Water</a></li>
                    <li><a href="{{ url('/services-emergency') }}">Emergency</a></li>
                    <li><a href="{{ url('/services-abled') }}">Special Abled Person</a></li>
                    <li><a href="#">Route Map</a></li>
                    <li><a href="{{ url('/services/lost_and_found_booth') }}">Lost & Found</a></li>
                    <li><a href="{{ url('/services/toilet') }}">Toilet</a></li>
                    <li><a href="{{ url('/services/beach') }}">Beaches</a></li>
                    <li><a href="{{ url('/services/life_guard_booth') }}">Life Guards</a></li>
                </ul>
            </li>

            <li><a href="#panji">Panji</a></li>
        </ul>
    </nav>
</header>
