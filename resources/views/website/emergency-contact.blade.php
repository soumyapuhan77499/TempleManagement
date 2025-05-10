<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Emergency Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/footer.css') }}">

</head>

<body>
    @include('partials.header-puri-dham')

    <section class="hero">
        <img class="hero-bg" src="{{ asset('website/fest.jpg') }}" alt="Mandir Background" />
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1>Emergency Contact</h1>
            <p>List Of Emergency Contact</p>
        </div>
    </section>

    <section class="py-12 px-4 md:px-12 bg-gray-100">
        <h2 class="text-3xl font-bold text-center mb-10 text-[#F06292]">Emergency Helpline Numbers</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-shield-alt text-[#FFA726] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Police</p>
                    <p class="text-gray-600">100</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-ambulance text-[#F06292] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Ambulance</p>
                    <p class="text-gray-600">108</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-fire-extinguisher text-[#FFA726] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Fire Service</p>
                    <p class="text-gray-600">101</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-user-shield text-[#F06292] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Elder Person Helpline</p>
                    <p class="text-gray-600">1090</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-child text-[#FFA726] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Child Helpline</p>
                    <p class="text-gray-600">1098</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-female text-[#F06292] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Women Helpline</p>
                    <p class="text-gray-600">1091</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-life-ring text-[#FFA726] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">Life Guard</p>
                    <p class="text-gray-600">8260777771</p>
                </div>
            </div>
    
            <div class="flex items-center gap-4 bg-white shadow-md p-4 rounded-lg">
                <i class="fas fa-road text-[#F06292] text-3xl"></i>
                <div>
                    <p class="font-semibold text-lg">National Highway Helpline</p>
                    <p class="text-gray-600">1033</p>
                </div>
            </div>
    
        </div>
    </section>
    

    @include('partials.website-footer')

</body>

</html>
