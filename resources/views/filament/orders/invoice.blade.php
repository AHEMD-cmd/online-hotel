<div>
    <!-- Your content here -->
    <h1>Order Invoice</h1>
    <p>Order Number: {{ $order->order_no }}</p>
    <p>Transaction ID: {{ $order->transaction_id }}</p>
    <p>Customer: {{ $order->user->name }}</p>
    <p>Paid Amount: {{ $order->paid_amount }}</p>
    <p>Payment Method: {{ $order->payment_method }}</p>
    <p>Booking Date: {{ $order->booking_date }}</p>
    <p>Status: {{ $order->status }}</p>

    <!-- You can add more details here -->
</div>
