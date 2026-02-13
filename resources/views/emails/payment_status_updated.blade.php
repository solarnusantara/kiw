<!DOCTYPE html>
<html>
<head>
    <title>Payment Status Updated</title>
</head>
<body>
    <h1>Payment Status Updated</h1>
    <p>Dear {{ $payment->name }},</p>
    <p>Your payment with reference ID {{ $payment->external_id }} has been updated to {{ $payment->status }}.</p>
    <p>Amount: {{ $payment->expected_amount }}</p>
    <p>Bank Code: {{ $payment->bank_code }}</p>
    <p>Account Number: {{ $payment->account_number }}</p>
    <p>Thank you for using our service.</p>
</body>
</html>
