<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Privacy Policy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Custom Header CSS -->
    <link rel="stylesheet" href="{{ asset('front-assets/frontend/css/dham-header.css') }}">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        section.privacy-policy {
            max-width: 900px;
            margin: 60px auto;
            background: #ffffff;
            padding: 40px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .privacy-policy h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .privacy-policy h3 {
            font-size: 20px;
            margin-top: 30px;
            color: #34495e;
        }

        .privacy-policy p,
        .privacy-policy li {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
        }

        .privacy-policy ul {
            padding-left: 20px;
        }

        .privacy-policy a {
            color: #007bff;
            text-decoration: none;
        }

        .privacy-policy a:hover {
            text-decoration: underline;
        }
    </style>

</head>

<body>
    @include('partials.header-puri-dham')

    <section class="privacy-policy">
        <h2>Our Commitment to Your Privacy</h2>

        <h3>1. Information We Collect</h3>
        <p>We collect personal information such as your name, email address, phone number, and shipping details when you place an order or sign up for our services. We also gather non-personal data like browser type, IP address, and device information to enhance your experience.</p>

        <h3>2. How We Use Your Data</h3>
        <ul>
            <li>To process your orders and ensure timely delivery.</li>
            <li>To send updates on new products, offers, and spiritual content.</li>
            <li>To improve our website experience and customer support.</li>
            <li>To comply with legal requirements and prevent fraud.</li>
        </ul>

        <h3>3. Data Protection Measures</h3>
        <p>We implement industry-standard security measures to protect your data from unauthorized access, loss, or misuse. Your payment details are encrypted and processed through secure gateways.</p>

        <h3>4. Sharing of Information</h3>
        <p>We do not sell or trade your personal information. However, we may share it with trusted third-party partners for logistics, payment processing, and customer support.</p>

        <h3>5. Your Rights</h3>
        <p>You have the right to request access, modification, or deletion of your personal data. If you wish to opt out of promotional communications, you can do so anytime.</p>

        <h3>6. Updates to Privacy Policy</h3>
        <p>We may update this policy periodically. Any changes will be communicated through our website and email notifications.</p>

        <h3>For Queries</h3>
        <p>If you have any questions or concerns about your privacy, contact us at <a href="mailto:jagannath.or@nic.in">jagannath.or@nic.in</a></p>
    </section>
</body>

</html>
