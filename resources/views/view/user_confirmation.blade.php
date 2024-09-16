<!DOCTYPE html>
<html>
<head>
    <title>Thank You for Your Enquiry</title>
</head>
<body>
    <h1>Thank You for Your Enquiry</h1>
    <p>Dear {{ $enquiry->name }},</p>
    <p>Thank you for reaching out to us. We have received your enquiry and will get back to you shortly.</p>
    {{-- Uncomment below lines if you want to include more details --}}
    {{-- <p><strong>Details:</strong></p>
    <p><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p><strong>Email:</strong> {{ $enquiry->email }}</p>
    <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
    <p><strong>Interested In:</strong> {{ $enquiry->interestedIn }}</p>
    <p><strong>Message:</strong> {{ $enquiry->message }}</p> --}}
</body>
</html>
