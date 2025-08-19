<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 1000px;
            margin: 20px auto;
            background-color: #ffffff;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .order-details {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .order-details th, .order-details td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .order-details th {
            background-color: #f8f9fa;
        }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;">
<div class="email-container" style="max-width: 1000px; margin: 20px auto; background-color: #ffffff; border: 1px solid #ddd; border-radius: 5px;">
    <div class="header" style="background-color: #007bff; color: #ffffff; padding: 20px; text-align: center; font-size: 24px; font-weight: bold;">Замовлення #{{ $order_id }} на сайті {{ config('app.name') }}</div>
    <div class="content" style="padding: 20px;">

        <table style="width: 100%;" class="order-details">
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>
            @foreach($cart as $product)
                <tr>
                    <td class="strip">{{ $product['title'] }}</td>
                    <td class="strip">${{ $product['price'] }}</td>
                    <td class="strip">{{ $product['quantity'] }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align: right;">
                    Total: ${{ $total }}
                </td>
            </tr>
            <tr>
                <td>Note</td>
                <td colspan="2">
                    {{ $note }}
                </td>
            </tr>
        </table>

    </div>
    <div class="footer" style="text-align: center; padding: 10px; font-size: 12px; color: #888;">
        Цей лист згенерований автоматично. Будь ласка, не відповідайте на нього.
    </div>
</div>
</body>
</html>

