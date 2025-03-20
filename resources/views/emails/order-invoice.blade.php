<!DOCTYPE html>
<html>
<head>
    <title>Facture</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ISI BURGER</h1>
        <p>Facture</p>
    </div>

    <div class="invoice-details">
        <p><strong>Client :</strong> {{ $order->name }}</p>
        <p><strong>Email :</strong> {{ $order->email }}</p>
        <p><strong>Adresse :</strong> {{ $order->address }}</p>
        <p><strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Quantité</th>
                <th>Prix unitaire</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $order->title }}</td>
                <td>{{ $order->quantity }}</td>
                <td>{{ number_format($order->price / $order->quantity, 2) }} €</td>
                <td>{{ $order->price }} €</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" class="total">Total TTC</td>
                <td>{{ $order->price }} €</td>
            </tr>
        </tfoot>
    </table>

    <p>Merci de votre confiance !</p>
</body>
</html> 