<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Special Abled Person</title>
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
            <h1>Special Abled Person</h1>
            <p>Instructions for Specially Abled Devotees</p>
        </div>
    </section>

    <!-- Special Abled Person Instruction Section -->
    <section class="py-12 px-6 md:px-16 bg-gray-50">
        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8">
            <div class="text-center mb-6">
                <i class="fas fa-wheelchair text-pink-500 text-5xl mb-4"></i>
                <h2 class="text-3xl font-bold text-pink-500">Special Abled Person Services</h2>
            </div>
            <p class="text-gray-700 text-md leading-relaxed">
                Free service of <strong>Battery operated vehicles</strong> is available from 
                <strong>Jagannatha Ballav Parking place (Market square)</strong> to the 
                <strong>Temple main gate / North gate</strong> for transporting senior citizens and physically challenged devotees.
            </p>
            <p class="text-gray-700 text-md mt-4 leading-relaxed">
                <strong>Wheelchair</strong> and <strong>Ramp facilities</strong> are available at the <strong>North gate</strong>.
            </p>
            <p class="text-gray-700 text-md mt-4 leading-relaxed">
                For availing a wheelchair, devotees can contact the <strong>Temple Supervisor / Assistant Supervisor</strong> at 
                <strong>06752 – 252527</strong>.
            </p>
            <p class="text-red-500 font-semibold mt-6">
                Note: Wheelchairs are available only for differently abled devotees.
            </p>
        </div>
    </section>

    @include('partials.website-footer')

</body>

</html>
