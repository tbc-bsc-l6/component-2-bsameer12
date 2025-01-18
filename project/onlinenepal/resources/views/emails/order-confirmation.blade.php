<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <main>
        <h2 style="text-align: center;">Order Received</h2>
        <p style="text-align: center;">Thank you for your order. Below are the details:</p>

        <div style="max-width: 600px; margin: 0 auto;">
            <h3>Your Order Details</h3>
            <p><strong>Order Number:</strong> {{ $order->id }}</p>
            <p><strong>Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</p>
            <p><strong>Total:</strong> Rs. {{ $order->total }}</p>
            <p><strong>Payment Method:</strong> {{ $order->transactions->mode }}</p>

            <h4>Order Items:</h4>
            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Product</th>
                        <th style="border: 1px solid #ddd; padding: 8px; text-align: right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItem as $item)
                        <tr>
                            <td style="border: 1px solid #ddd; padding: 8px;">{{ $item->product->name }} x {{ $item->quantity }}</td>
                            <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rs. {{ number_format((float)$item->price * (int)$item->quantity, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Subtotal</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rs. {{ $order->subtotal }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Discount</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rs. {{ $order->discount }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Shipping</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Free shipping</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">VAT</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rs. {{ $order->tax }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #ddd; padding: 8px; text-align: left;">Total</th>
                    <td style="border: 1px solid #ddd; padding: 8px; text-align: right;">Rs. {{ $order->total }}</td>
                </tr>
            </table>
        </div>
    </main>
</body>
</html>
