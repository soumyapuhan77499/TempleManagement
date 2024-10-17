<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Invoice</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }

        .invoice-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            max-width: 800px;
            margin: auto;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header img {
            max-width: 150px;
        }

        .invoice-header h1 {
            font-size: 24px;
            margin: 10px 0;
        }

        .invoice-details {
            margin-bottom: 20px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 15px;
        }

        .invoice-details h4 {
            margin: 5px 0;
        }

        .table th,
        .table td {
            vertical-align: middle;
            padding: 12px;
        }

        .table th {
            background-color: #007bff;
            color: white;
            text-align: left;
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
            text-align: right;
        }

        .text-center {
            text-align: center;
            margin-top: 30px;
        }

        .btn-print {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="invoice-container">
        <div class="invoice-header">
            <img src="http://temple.mandirparikrama.com/front-assets/images/logo.png" alt="Logo">
            <h1>Payment Invoice</h1>
        </div>
        <div class="invoice-details d-flex justify-content-between">
            <h4>Voucher No: {{ $expenditure->voucher_number }}</h4>
            <h4>Date: {{ \Carbon\Carbon::parse($expenditure->payment_date)->format('d M Y') }}</h4>
        </div>
        
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Field</th>
                    <th>Details</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Person Name</td>
                    <td>{{ $expenditure->person_name }}</td>
                </tr>
                <tr>
                    <td>Amount</td>
                    <td>{{ number_format($expenditure->amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Category</td>
                    <td>{{ $expenditure->category }}</td>
                </tr>
                <tr>
                    <td>Category Type</td>
                    <td>{{ $expenditure->category_type }}</td>
                </tr>
                <tr>
                    <td>Payment Mode</td>
                    <td>{{ $expenditure->payment_mode }}</td>
                </tr>
                <tr>
                    <td>Payment Number</td>
                    <td>{{ $expenditure->payment_number }}</td>
                </tr>
                <tr>
                    <td>Payment Done By</td>
                    <td>{{ $expenditure->payment_done_by }}</td>
                </tr>
                <tr>
                    <td>Description</td>
                    <td>{{ $expenditure->payment_description }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-amount">
            Total Amount: {{ number_format($expenditure->amount, 2) }}
        </div>

        <div class="text-center">
            <button onclick="window.print()" class="btn btn-primary btn-print">Print Invoice</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
