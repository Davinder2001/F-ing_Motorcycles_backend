<!DOCTYPE html>
<html>
<head>
    <title>Enquiry Received</title>
</head>
<body>
    <h1>New Enquiry Received</h1>
    <p><strong>Name:</strong> {{ $enquiry->name }}</p>
    <p><strong>Email:</strong> {{ $enquiry->email }}</p>
    <p><strong>Phone:</strong> {{ $enquiry->phone }}</p>
    <p><strong>Interested In:</strong> {{ $enquiry->interestedIn }}</p>
    <p><strong>Message:</strong> {{ $enquiry->message }}</p>
</body>
</html>
