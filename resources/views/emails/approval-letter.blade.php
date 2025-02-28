<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Approval Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.5;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .content {
            margin: 30px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Approval Letter</h1>
            <h3>Direct Needs Program</h3>
        </div>

        <div class="content">
            <p>Dear {{ $applicantName }},</p>
            <p>We are pleased to inform you that your application has been approved.</p>
            <p><strong>Grant Amount:</strong> ${{ $grantAmount }}</p>
            <p><strong>Approval Date:</strong> {{ $approvalDate }}</p>
            <p>Kindly follow the provided instructions to access your grant.</p>
            <p>Thank you for being a part of our community. We wish you success in your endeavors.</p>
        </div>

        <div class="footer">
            &copy; 2025 Direct Needs Program. All rights reserved.
        </div>
    </div>
</body>
</html>
