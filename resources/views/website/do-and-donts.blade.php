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
            <h1>Do's and don'ts</h1>
            <p>To preserve the sanctity and traditions of Shree Jagannatha Dham.</p>
        </div>
    </section>
<section class="py-12 bg-gray-50">
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">  

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <!-- DO's -->
      <div class="bg-white rounded-lg shadow p-6 border-t-4 border-green-500">
        <h3 class="text-xl font-semibold text-green-600 mb-4 flex items-center">
          <i class="fas fa-check-circle mr-2"></i> DO’S
        </h3>
        <ul class="space-y-3 list-inside list-disc text-gray-800">
          <li>Follow the Queue System for hassle-free darshan of Deities.</li>
          <li>Respect ancient customs and usages while at Shree Jagannatha Temple and promote religious sentiments among co-pilgrims.</li>
          <li>Observe absolute silence inside the temple.</li>
          <li>Deposit your offerings in the Hundi and Branch Office inside the temple premises.</li>
          <li>Keep clean the premises of Shree Jagannatha Temple.</li>
          <li>Bath and wear clean clothes before you enter the shrine.</li>
          <li>Beware of pickpockets and monkeys.</li>
        </ul>
      </div>

      <!-- DON'Ts -->
      <div class="bg-white rounded-lg shadow p-6 border-t-4 border-red-500">
        <h3 class="text-xl font-semibold text-red-600 mb-4 flex items-center">
          <i class="fas fa-ban mr-2"></i> DON’TS
        </h3>
        <ul class="space-y-3 list-inside list-disc text-gray-800">
          <li>Consume liquor or other intoxicants during Darshan of the Deities.</li>
          <li>Eat non-vegetarian food.</li>
          <li>Carry cooked food.</li>
          <li>Encourage beggary.</li>
          <li>Spit or commit nuisance.</li>
          <li>Waste water.</li>
          <li>Spit, urinate or defecate in the premises of temple.</li>
          <li>Footwear and leather items in and around the premises of the temple.</li>
          <li>Carry umbrella, mobile phones, electronic gadgets, leather items etc.</li>
        </ul>
      </div>
    </div>
  </div>
</section>

    @include('partials.website-footer')

</body>

</html>
