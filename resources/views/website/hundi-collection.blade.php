<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hundi Collection</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/footer.css') }}">

</head>

<body>
    @include('partials.header-puri-dham')

    <!-- Hero Banner -->
    <section class="hero">
        <img class="hero-bg" src="{{ asset('website/fest.jpg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Hundi Collection</h1>
        </div>
    </section>

    <!-- Hundi Collection Section -->
    <section class="py-12 px-4 md:px-8 bg-gray-50">
        <div class="max-w-xl mx-auto bg-white rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-3xl font-bold mb-6 text-[#db4d30]">Hundi Collection Details</h2>
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
    </section>

    @include('partials.website-footer')
    
    <script>
        function openMobileMenu() {
          document.getElementById('mobileNav').classList.add('active');
          document.querySelector('.hamburger-icon').classList.add('active');
        }
      
        function closeMobileMenu() {
          document.getElementById('mobileNav').classList.remove('active');
          document.querySelector('.hamburger-icon').classList.remove('active');
        }
      </script>
      

</body>

</html>
