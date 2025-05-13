<!DOCTYPE html>
<html lang="en">

<head>
    <!--====== Required meta tags ======-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    @yield('og-meta')
    <!--====== Title ======-->
    <title>@yield('pagename')</title>
    <!--====== Favicon Icon ======-->
    {{-- <link rel="shortcut icon" href="{{ asset('assets/front/img/' . $bs->favicon) }}" type="image/png"> --}}
    <link rel="stylesheet" href="{{ asset('assets/front/css/plugin.min.css') }}">
    {{-- <!--====== Bootstrap css ======-->
    <!--====== Default css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/default.css')}}">
    <!--====== Style css ======-->
    <link rel="stylesheet" href="{{asset('assets/front/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/front/css/cookie-alert.css')}}">
    @if ($rtl == 1)
        <link rel="stylesheet" href="{{asset('assets/front/css/rtl-style.css')}}">
    @endif --}}
    <!-- base color change -->
    {{-- <link href="{{ asset('assets/front/css/style-base-color.php') . '?color=' . $bs->base_color }}" rel="stylesheet"> --}}
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/bootstrap.min.css') }}">
    <!-- Fontawesome Icon CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/fontawesome/css/all.min.css') }}">
    <!-- Swiper Slider -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/swiper-bundle.min.css') }}">
    <!-- Kreativ Icon -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/fonts/icomoon/style.css') }}">
    {{-- Toastr css  --}}
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/toastr.min.css') }}">
    <!-- Magnific Popup CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/magnific-popup.min.css') }}">
    <!-- AOS Animation CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/aos.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/nice-select.css') }}">
    <!-- Main Style CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- summernote Style CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/summernote-content.css') }}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/responsive.css') }}">
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@400&display=swap" rel="stylesheet">

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/puri-dhams.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/banner.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/niti.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/shree-mandir.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/service.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/temple-slider.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/convience.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/footer.css') }}">

</head>

<body>
    {{-- <!-- Emergency Modal -->
    <div id="emergencyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl relative">
            <button onclick="closeEmergencyModal()" class="absolute top-3 right-3 text-gray-600 hover:text-red-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <h2 class="text-2xl font-bold mb-6 text-center text-pink-500">Emergency Helpline Numbers</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex items-center gap-4">
                    <i class="fas fa-shield-alt text-blue-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Police</p>
                        <p class="text-gray-600 text-sm">100</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-ambulance text-red-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Ambulance</p>
                        <p class="text-gray-600 text-sm">108</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-fire-extinguisher text-orange-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Fire Service</p>
                        <p class="text-gray-600 text-sm">101</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-user-shield text-green-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Elder Person Helpline</p>
                        <p class="text-gray-600 text-sm">1090</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-child text-yellow-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Child Helpline</p>
                        <p class="text-gray-600 text-sm">1098</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-female text-pink-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Women Helpline</p>
                        <p class="text-gray-600 text-sm">1091</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-life-ring text-blue-400 text-2xl"></i>
                    <div>
                        <p class="font-semibold">Life Guard</p>
                        <p class="text-gray-600 text-sm">8260777771</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <i class="fas fa-road text-gray-500 text-2xl"></i>
                    <div>
                        <p class="font-semibold">National Highway Helpline</p>
                        <p class="text-gray-600 text-sm">1033</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Special Abled Person Modal -->
    <div id="specialModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-2xl relative">
            <button onclick="closeSpecialModal()" class="absolute top-3 right-3 text-gray-600 hover:text-red-600">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <div class="text-center">
                <i class="fas fa-wheelchair text-pink-500 text-5xl mb-4"></i>
                <h2 class="text-2xl font-bold mb-4 text-pink-500">Special Abled Person Services</h2>
                <p class="text-gray-700 leading-relaxed text-md">
                    Free service of Battery operated vehicles are available from <strong>Jagannatha Ballav Parking place
                        (Market square)</strong> to Temple main gate / North gate for carrying senior citizens and
                    physically challenged people.<br><br>
                    Wheel chair and Ramp facilities are available at <strong>North gate</strong>.<br><br>
                    For availing wheelchair, one can contact Temple Supervisor / Assistant Supervisor at <strong>06752 –
                        252527</strong>.<br><br>
                    <span class="text-red-500 font-semibold">Note:</span> Wheelchairs are available only for
                    differently abled devotees.
                </p>
            </div>
        </div>
    </div>

    <!-- Donation Warning Modal -->
    <div id="donationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96 relative text-center">
            <h2 class="text-xl font-bold mb-4 text-red-600">Important!</h2>
            <p class="text-gray-700 mb-6">You are navigating to Shree Mandira official Donation Platform.</p>

            <div class="flex justify-center gap-5">
                <button onclick="confirmDonation()"
                    class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600 transition">
                    Confirm
                </button>
                <button onclick="closeDonationModal()"
                    class="px-4 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">
                    Cancel
                </button>
            </div>
        </div>
    </div>

    <!-- Hundi Collection Modal -->
    <div id="hundiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg p-8 w-96 relative text-center">
            <button onclick="closeHundiModal()"
                class="absolute top-2 right-2 text-gray-600 hover:text-red-600 text-xl">
                <i class="fas fa-times"></i>
            </button>

            <h2 class="text-2xl font-bold mb-6 text-[#db4d30]">Hundi Collection Details</h2>

            @if ($hundi)
                <div class="space-y-4 text-gray-700 text-md">
                    <p><strong>Rupees Collected:</strong> ₹{{ number_format($hundi->rupees, 2) }}</p>
                    <p><strong>Gold Collected:</strong> {{ $hundi->gold ?? 0 }} gm</p>
                    <p><strong>Silver Collected:</strong> {{ $hundi->silver ?? 0 }} gm</p>
                </div>
            @else
                <p class="text-gray-500 italic">No Hundi collection data available for today.</p>
            @endif
        </div>
    </div> --}}

    <!-- Content -->
    @yield('content')
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Jquery JS -->
    <script src="front-assets/frontend/js/jquery.min.js"></script>
    <script src="assets/front/js/plugin.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="front-assets/frontend/js/bootstrap.min.js"></script>
    <!-- Nice Select JS -->
    <script src="front-assets/frontend/js/jquery.nice-select.min.js"></script>
    <!-- Magnific Popup JS -->
    <script src="front-assets/frontend/js/jquery.magnific-popup.min.js"></script>
    <!-- Swiper Slider JS -->
    <script src="front-assets/frontend/js/swiper-bundle.min.js"></script>
    <!-- Lazysizes -->
    <script src="front-assets/frontend/js/lazysizes.min.js"></script>
    <!-- SVG loader -->
    <script src="front-assets/frontend/js/svg-loader.min.js"></script>
    <!-- AOS JS -->
    <script src="front-assets/frontend/js/aos.min.js"></script>
    <script src="front-assets/frontend/js/toastr.min.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>

    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script>
        "use strict";
        var rtl = false; // Hardcoded for static version
    </script>

    <!-- Main script JS -->
    <script src="front-assets/frontend/js/script.js"></script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

    {{-- slide temple --}}

    <script>
        const swiper = new Swiper(".mySwiper", {
            effect: "coverflow",
            grabCursor: true,
            centeredSlides: true,
            loop: true,
            slidesPerView: 4, // show 7 slides total
            initialSlide: 3, // make sure the center one is visible initially
            coverflowEffect: {
                rotate: 0,
                stretch: 0,
                depth: 150,
                modifier: 2.5,
                slideShadows: false,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>

    {{-- Emergency contact --}}
    <script>
        function openEmergencyModal() {
            document.getElementById('emergencyModal').classList.remove('hidden');
        }

        function closeEmergencyModal() {
            document.getElementById('emergencyModal').classList.add('hidden');
        }
    </script>

    {{-- Special Abled Person --}}
    <script>
        function openSpecialModal() {
            document.getElementById('specialModal').classList.remove('hidden');
        }

        function closeSpecialModal() {
            document.getElementById('specialModal').classList.add('hidden');
        }
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>

    <script>
        // Auto-activate About Temple tab when page loads
        document.addEventListener("DOMContentLoaded", function() {
            const defaultTab = document.querySelector('.tab-item[data-tab="aboutTemple"]');
            if (defaultTab) {
                defaultTab.click();
            }
        });
    </script>

    {{-- temple information --}}
    <script>
        const tabData = {
            lordSupreme: {
                title: "Lord Supreme",
                description: "Lord Jagannatha, as His very name signifies, is the Lord of the Universe (Jagat = Universe; Natha = Lord). He is also popularly known as Mahaprabhu (Maha = Great; Prabhu = Lord). The sacred scriptures of Sanatana Vaidika Dharma (popularly known as Hinduism) also refer to Him as Purushottama, The Supreme Divine Being (Purusha = Divine Being; Uttama = Supreme). The glory of Lord Jagannatha has been narrated in innumerable scriptures – from the Vedas (the earliest scriptures of mankind) to the Puranas and later literary compositions in Sanskrit and Odia languages.",
                image: "website/temple_info/sup.png",

            },

            throughAges: {
                title: "Through The Ages",
                description: "Legendary origin of Puri and the shrine of Purushottama has been described vividly in Brahma Purana, Narada Purana and Utkal Khanda (Purushottama Mahatmya) of Skanda Purana. Among these three Puranas the description of Skanda Purana is more elaborate. As per the Purana, King Indradymana was ruling over the Malava Country in Satya Yuga (the age of Truth). Indradymna was a great devotee of Vishnu. Once he came to know about Purushottama, on the shore of the South Sea from his family priests and pilgrims. He was informed that, on the Nilachala (blue hill), image of Vasudeva made of blue sapphire was being worshipped by the Sabaras (a tribal clan). The King in consultation with the family prist, deputed Vidyapati (the brother of the priest) to locate the site. ",
                image: "website/temple_info/age.png",

            },


            tradition: {
                title: "Living Tradition",
                description: `The daily and periodical rituals observed and performed in His service and worship since time immemorial, bear the dignity and grandeur which a supreme person is entitled to.
                The ritual system of the temple is very elaborate and complex involving a multitude of functionaries.
                The rituals of Lord Shree Jagannatha can broadly be divided into three categories i.e. the daily, the occasional (periodical) and the festive.
                In Shree Jagannatha temple, these rituals assure the term "Niti".
                The fixed nitis that are observed daily are a matter of routine.
                Each Sevaka or Servitor of the temple has his specific role to play in these nitis with terms and times already specified.
                The various nitis, that are observed daily in the temple commence at about 5 am and continue till late night.`,
                image: "website/temple_info/tradition.png",


            },

            festivals: {
                title: "Festivals",
                description: `Old Sanskrit texts, right from Brahma and Skanda Purana onwards, contain prescription about the observance of twelve festivals in the temple of Jagannatha throughout the year. These twelve festivals, popularly called ‘dvadasa yatras’.
            These twelve festivals are:
            (1) Snana (bathing),
            (2) Ratha (moving by chariot),
            (3) Sayana (sleeping),
            (4) Uttarayana,
            (5) Daksinayana,
            (6) Parsva Parivartana (changing of sides),
            (7) Utthapana (awakening),
            (8) Pravarana (covering the body),
            (9) Pusyabhiseka (coronation),
            (10) Dola (swinging),
            (11) Damanaka Bhanjana (breaking of Damanaka plant) and
            (12) Aksaya Trtiya (Chandan yatra).
            Besides that another festival namely ‘Neeladri Mahodaya’ known as froyadasha yatra of the temple.
            There is a popular saying: “Thirteen festivals are there in twelve months”.`,
                image: "website/temple_info/festival.jpeg",

            },

            ratha: {
                title: "Ratha Yatra",
                description: `As per description in the Skanda Purana, among the twelve Yatras of Shree Jagannatha, Ratha Yatra or Shree Gundicha Yatra is considered the most famous one.
            According to ‘Bamadev Samhita’, those who can witness the four deities on the Simhasana (the sacred seat) of Gundicha Temple for a week, they along with their ancestors would get a place in the heavenly abode i.e. Baikuntha for all time to come.
            As per this text, those who can hear about this great festival also get the desired result.
            Besides this, those who study the rituals of the divine festival and make others aware of the same can also get a place in His holy abode.`,
                image: "website/temple_info/ratha.png",

            },

            services: {
                title: "Visitor Services",
                description: `Darshan of Shree Jagannatha Mahaprabhu is available almost throughout the day i.e. from early in the morning till late night excepting some festive occasions.
            Generally, Temple opens and darshan starts at around 5.30 A.M.
            After offering of the perpetual lamp (Mangal Arati), devotees are allowed entry up to Jagamohan (Bhitar Kaatha) of the temple and darshan from this point is available till completion of “Besha” (approximately up to 7.30 / 8 A.M.).
            Darshan of Shree Jagannatha Mahaprabhu is not available for 1 hr 15 minutes after completion of Besha (approximately from 8 A.M. to 9.15 A.M.) for performance of Gopal Ballava Puja.`,
                image: "website/temple_info/devt.png",

            },
            management: {
                title: "Management",
                description: "The affairs of Shree Jagannatha Temple at Puri were looked after with great devotion and care by the successive Hindu ruling dynasties of Odisha for whom Shree Jagannatha Mahaprabhu had come to be regarded as the State deity. The famous Ganga Monarch Chodaganga Deva, after constructing the present temple in the 12th century A.D, made new endowments and laid the foundation of a sound administration for managing the affairs of the Temple. Madala Panji, the chronicle of Shree Jagannatha Temple, Puri, eulogistically records the extensive endowments in land and fabulous gifts of gold made by Anangabhima Deva (III). He is also credited with organising the Chhatisa Nijog or as many as thirty six genres of temple servitors and instituting numerous bhogas and yatras (festivals).",
                image: "website/temple_info/management.jpg",
            }
        };
    </script>

    <script>
        function loadTabContent(tabKey) {
            const tabInfo = tabData[tabKey];

            // Update image
            document.getElementById('contentImage').src = "{{ asset('') }}" + tabInfo.image;

            // Update title and description
            document.getElementById('contentTitle').textContent = tabInfo.title;
            document.getElementById('contentDescription').textContent = tabInfo.description;

            // Clear old buttons
            const buttonContainer = document.getElementById('buttonContainer');
            buttonContainer.innerHTML = '';

            // Add new buttons
            tabInfo.buttons.forEach(button => {
                const btn = document.createElement('a');
                btn.href = button.url;
                btn.textContent = button.name;
                btn.className =
                    'bg-gradient-to-r from-orange-400 to-pink-400 hover:from-orange-500 hover:to-pink-500 text-white font-bold py-2 px-2 rounded transition duration-300';
                buttonContainer.appendChild(btn);
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            loadTabContent('lordSupreme'); // Load default content

            // Set default active tab underline
            const defaultTab = document.querySelector('.tab-item[data-tab="lordSupreme"]');
            if (defaultTab) {
                defaultTab.classList.add('active-tab');
                defaultTab.classList.remove('inactive-tab');

                const titleText = defaultTab.querySelector('p');
                if (titleText) {
                    titleText.style.background = "linear-gradient(90deg, #FFA726, #F06292)";
                    titleText.style.webkitBackgroundClip = "text";
                    titleText.style.webkitTextFillColor = "transparent";
                }

                const underline = document.createElement('div');
                underline.classList.add('h-1', 'w-full', 'mt-1');
                underline.style.background = "linear-gradient(90deg, #FFA726, #F06292)";
                underline.style.borderRadius = "4px";
                defaultTab.appendChild(underline);
            }
        });

        // Tab click handler
        document.querySelectorAll('.tab-item').forEach(item => {
            item.addEventListener('click', function() {
                // Reset all tabs
                document.querySelectorAll('.tab-item').forEach(t => {
                    t.classList.remove('active-tab');
                    t.classList.add('inactive-tab');
                    const titleText = t.querySelector('p');
                    if (titleText) {
                        titleText.style.background = "none";
                        titleText.style.webkitTextFillColor = "#6B7280"; // text-gray-500 color
                    }
                    const underline = t.querySelector('div.h-1');
                    if (underline) {
                        underline.remove();
                    }
                });

                // Activate clicked tab
                this.classList.add('active-tab');
                this.classList.remove('inactive-tab');

                const clickedTitleText = this.querySelector('p');
                if (clickedTitleText) {
                    clickedTitleText.style.background = "linear-gradient(90deg, #FFA726, #F06292)";
                    clickedTitleText.style.webkitBackgroundClip = "text";
                    clickedTitleText.style.webkitTextFillColor = "transparent";
                }

                const underline = document.createElement('div');
                underline.classList.add('h-1', 'w-full', 'mt-1');
                underline.style.background = "linear-gradient(90deg, #FFA726, #F06292)";
                underline.style.borderRadius = "4px";
                this.appendChild(underline);

                // Load tab content
                const tabKey = this.getAttribute('data-tab');
                loadTabContent(tabKey);
            });
        });
    </script>

    <script>
        function toggleMobileNav() {
            const mobileNav = document.getElementById("mobileNav");
            mobileNav.classList.toggle("hidden");
        }
    </script>

    {{-- temple world wide --}}
    <script>
        function showContent(tab, element) {
            // Remove active class from all buttons
            document.querySelectorAll(".tab-buttons").forEach(button => {
                button.classList.remove("active-tabs");
                button.classList.remove("underline-effect");
            });

            // Add active class to clicked button
            element.classList.add("active-tabs");
            element.classList.add("underline-effect");

            // Update image based on selected tab
            let imagePath = "";
            let altText = "";

            if (tab === "worldwide") {
                imagePath = "{{ asset('website/18.png') }}";
                altText = "Jagannatha Temples Worldwide";
            } else if (tab === "india") {
                imagePath = "{{ asset('website/india.png') }}";
                altText = "Jagannatha Temples in India";
            } else if (tab === "odisha") {
                imagePath = "{{ asset('website/odisha.png') }}"; // You can also switch this to .svg if available
                altText = "Jagannatha Temples in Odisha";
            }

            // Change the image source and alt
            const imgEl = document.getElementById("dynamicImage");
            imgEl.src = imagePath;
            imgEl.alt = altText;
        }
    </script>

    {{-- banner video --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const video = document.getElementById("bannerVideo");
            const playPauseButton = document.getElementById("playPauseButton");
            const muteToggle = document.getElementById("muteToggle");
            const hamburger = document.querySelector(".hamburger-icon");
            const navMenu = document.querySelector(".nav-menu");
            const navClose = document.querySelector(".nav-close");

            // Play/Pause Toggle
            playPauseButton.addEventListener("click", function() {
                if (video.paused) {
                    video.play();
                    this.innerHTML = '<i class="fa fa-pause"></i>';
                } else {
                    video.pause();
                    this.innerHTML = '<i class="fa fa-play"></i>';
                }
            });

            // Mute/Unmute Toggle
            muteToggle.addEventListener("click", function() {
                video.muted = !video.muted;
                this.innerHTML = video.muted ?
                    '<i class="fa fa-volume-mute"></i>' :
                    '<i class="fa fa-volume-up"></i>';
            });

            // Scroll-triggered pause
            function checkScroll() {
                const rect = video.getBoundingClientRect();
                const inView = rect.top < window.innerHeight && rect.bottom > 0;
                if (!inView) {
                    video.pause();
                    playPauseButton.innerHTML = '<i class="fa fa-play"></i>';
                }
            }
            window.addEventListener("scroll", checkScroll);

            // Navigation Toggle
            hamburger.addEventListener("click", function() {
                hamburger.classList.toggle("active");
                navMenu.classList.toggle("active");
                console.log("Hamburger clicked, nav toggled");
            });

            navClose.addEventListener("click", function() {
                navMenu.classList.remove("active");
                hamburger.classList.remove("active");
            });
        });
    </script>

    {{-- temple information --}}
    <script>
        document.querySelectorAll('.tab-item').forEach(tab => {
            tab.addEventListener('mouseenter', () => {
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active-tab'));
                tab.classList.add('active-tab');
            });

            tab.addEventListener('mouseleave', () => {
                document.querySelectorAll('.tab-item').forEach(t => t.classList.remove('active-tab'));
                const defaultTab = document.querySelector('[data-tab="aboutTemple"]'); // your default tab
                defaultTab.classList.add('active-tab');
            });
        });
    </script>

    {{-- donation modal --}}
    <script>
        function openDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
        }

        function closeDonationModal() {
            document.getElementById('donationModal').classList.add('hidden');
        }

        function confirmDonation() {
            window.location.href = "https://www.shreejagannatha.in/donation/";
        }
    </script>

    <script>
        lucide.createIcons();
    </script>

    <script>
        function openHundiModal() {
            document.getElementById('hundiModal').classList.remove('hidden');
        }

        function closeHundiModal() {
            document.getElementById('hundiModal').classList.add('hidden');
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const calendarContainer = document.getElementById("calendar");
            const eventsContainer = document.getElementById("events");

            function generateCalendar(year, month) {
                const today = new Date();
                const firstDay = new Date(year, month, 1);
                const lastDay = new Date(year, month + 1, 0);
                const daysInMonth = lastDay.getDate();
                const startDay = firstDay.getDay();

                let html = `
            <div class="flex justify-between items-center mb-4">
                <button id="prevMonth" class="text-gray-600">◀</button>
                <h2 class="text-lg font-bold">${firstDay.toLocaleString('default', { month: 'long' })} ${year}</h2>
                <button id="nextMonth" class="text-gray-600">▶</button>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center text-gray-500 font-semibold">
                <div>S</div><div>M</div><div>T</div><div>W</div><div>T</div><div>F</div><div>S</div>
            </div>
            <div class="grid grid-cols-7 gap-2 mt-2 text-center">
        `;

                for (let i = 0; i < startDay; i++) {
                    html += `<div></div>`; // Empty slots for previous month
                }

                for (let day = 1; day <= daysInMonth; day++) {
                    const isToday = today.getDate() === day && today.getMonth() === month && today.getFullYear() ===
                        year;
                    html += `
                    <div class="p-2 rounded-full cursor-pointer ${isToday ? "bg-red-500 text-white" : "hover:bg-gray-200"}" data-day="${day}">
                        ${day}
                    </div>
                `;
                }

                html += `</div>`;
                calendarContainer.innerHTML = html;

                document.getElementById("prevMonth").addEventListener("click", () => updateCalendar(year, month -
                    1));
                document.getElementById("nextMonth").addEventListener("click", () => updateCalendar(year, month +
                    1));

                document.querySelectorAll("#calendar div[data-day]").forEach(dayEl => {
                    dayEl.addEventListener("click", function() {
                        // Reset background
                        document.querySelectorAll("#calendar div[data-day]").forEach(el => el
                            .classList.remove("bg-red-500", "text-white"));
                        this.classList.add("bg-red-500", "text-white");

                        const selectedDay = this.getAttribute("data-day");
                        const selectedDate = formatDate(year, month + 1,
                            selectedDay); // month+1 because JS month starts from 0
                        loadPanjiDetails(selectedDate); // 👈 load panji event on date click
                    });
                });
            }

            function updateCalendar(year, month) {
                if (month < 0) {
                    year -= 1;
                    month = 11;
                } else if (month > 11) {
                    year += 1;
                    month = 0;
                }
                generateCalendar(year, month);
            }

            function formatDate(year, month, day) {
                // Format as YYYY-MM-DD (pad zeroes)
                const m = month < 10 ? '0' + month : month;
                const d = day < 10 ? '0' + day : day;
                return `${year}-${m}-${d}`;
            }

            // Ajax Load Panji Details
            function loadPanjiDetails(selectedDate) {
                fetch('{{ route('get.panji.details') }}', {
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}",
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            date: selectedDate
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        const panjiContent = document.getElementById('panjiContent');
                        if (data) {
                            panjiContent.innerHTML = `
                        <div class="flex items-start gap-3">
                            <i class="fas fa-calendar-day text-green-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">${data.event_name ?? 'No Event'}</p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-star text-purple-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Tithi: <span class="font-medium">${data.tithi ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-smile text-yellow-500 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Yoga: <span class="font-medium">${data.yoga ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-adjust text-blue-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Paksha: <span class="font-medium">${data.pakshya ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-clock text-red-400 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Sunrise: <span class="font-medium">${data.sun_rise ?? '-'}</span></p>
                        </div>
                        <div class="flex items-start gap-3">
                            <i class="fas fa-moon text-indigo-600 mt-1 w-5 h-5"></i>
                            <p class="text-gray-800">Sunset: <span class="font-medium">${data.sun_set ?? '-'}</span></p>
                        </div>
                        ${data.description ? `
                                        <hr class="border-dashed border-gray-300 my-4">
                                        <div class="flex items-start gap-3">
                                            <i class="fas fa-info-circle text-gray-600 mt-1 w-5 h-5"></i>
                                            <p class="text-gray-800">${data.description}</p>
                                        </div>` : ''}
                    `;
                        } else {
                            panjiContent.innerHTML =
                                `<p class="text-center text-gray-500">No Panji Details Available for selected date.</p>`;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching Panji details:', error);
                    });
            }

            const now = new Date();
            generateCalendar(now.getFullYear(), now.getMonth());
        });
    </script>

</body>

</html>
