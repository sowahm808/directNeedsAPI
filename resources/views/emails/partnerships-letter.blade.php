<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Partnerships and Community Support</title>
</head>
<body>
    <h1>Hello, {{ $applicantName }}</h1>
    <p>
        We hope this message finds you well. We are reaching out to inform you of community support options available as part of your approved grant of <strong>${{ number_format($grantAmount, 2) }}</strong>.
    </p>

    <p>
        Your application was approved on <strong>{{ \Carbon\Carbon::parse($approvalDate)->format('F d, Y') }}</strong>.
    </p>

    <p>
        We are committed to supporting you through partnerships and community resources. If you have any questions, feel free to reach out to us.
    </p>

    <p>Best regards,<br/>Direct Needs Program Team</p>
</body>
</html>
