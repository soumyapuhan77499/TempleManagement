<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst(str_replace('_', ' ', $service_type)) }} Services</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <style>
        body {
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
        }
        .table-header {
            background: linear-gradient(90deg, #FFA726, #F06292);
            color: white;
        }
        .table-row:nth-child(even) {
            background-color: #fdf2f8;
        }
        .table-row:nth-child(odd) {
            background-color: #fff7f0;
        }
       
    </style>
</head>

<body>
    @include('partials.header-puri-dham')

    <!-- Hero Section -->
    <div class="hero">
        <img class="hero-bg" src="{{ asset('website/parking.jpeg') }}" alt="Mandir Background" />
        <div class="hero-content">
            <h1 class="text-4xl font-bold">{{ ucfirst(str_replace('_', ' ', $service_type)) }}</h1>
            <p class="text-lg mt-2">Explore all available services here</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="container mx-auto p-8">
        <div class="overflow-x-auto rounded-lg shadow-lg bg-white">
            <table class="min-w-full">
                <thead class="table-header">
                    <tr>
                        <th class="py-3 px-6 text-left">Service Name <i class="fas fa-concierge-bell"></i></th>
                        <th class="py-3 px-6 text-left">Photo <i class="fas fa-image"></i></th>
                        <th class="py-3 px-6 text-left">Contact No <i class="fas fa-phone"></i></th>
                        <th class="py-3 px-6 text-left">Opening Time <i class="fas fa-clock"></i></th>
                        <th class="py-3 px-6 text-left">Closing Time <i class="fas fa-clock"></i></th>
                        <th class="py-3 px-6 text-left">City <i class="fas fa-city"></i></th>
                        <th class="py-3 px-6 text-left">Description <i class="fas fa-info-circle"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                    <tr class="table-row hover:bg-pink-100 transition duration-300">
                        <td class="py-4 px-6">{{ $service->service_name }}</td>
                        <td class="py-4 px-6">
                            @if($service->photo)
                                <img src="{{ asset('uploads/public_services/' . $service->photo) }}" alt="{{ $service->service_name }}" class="w-16 h-16 object-cover rounded-md shadow-md">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">{{ $service->contact_no }}</td>
                        <td class="py-4 px-6">{{ $service->opening_time }}</td>
                        <td class="py-4 px-6">{{ $service->closing_time }}</td>
                        <td class="py-4 px-6">{{ $service->city_village }}</td>
                        <td class="py-4 px-6">{{ $service->description }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-6 text-lg text-red-500">No Services Found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>
