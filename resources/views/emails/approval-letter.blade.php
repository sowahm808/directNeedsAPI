<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approval Letter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: auto;
        }
        .header, .footer, .signature {
            text-align: center;
        }
        .content {
            margin-top: 20px;
        }
        h1, h3 {
            margin-bottom: 10px;
        }
        ul {
            list-style: square;
            margin-left: 20px;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <p><strong>Applicant:</strong> {{ $applicantName ?? 'N/A' }}</p>
        <h1>Approval Letter</h1>
        <h3>The Grandparents Community Network (TGCN) - Direct Needs Program</h3>
    </div>

    <div class="content">
        <p>Dear {{ $applicantName ?? 'Applicant' }},</p>

        <p>
            We are pleased to inform you that your application for assistance through The Grandparents Community Network (TGCN) Direct Needs Program has been approved. After reviewing your request and supporting documents, we have determined that you qualify for assistance in the following category:
        </p>

        <h3>Approved Assistance Category:</h3>
        <ul>
            <li>
                <strong>{{ $assistanceCategory ?? 'General Assistance' }}:</strong>
                ${{ isset($grantAmount) && is_numeric($grantAmount) ? number_format($grantAmount, 2) : 'N/A' }}
            </li>
        </ul>

        @if(!empty($customBody))
            <div>{!! nl2br(e($customBody)) !!}</div>
        @else
            <p>
                The total approved grant of ${{ isset($grantAmount) && is_numeric($grantAmount) ? number_format($grantAmount, 2) : 'N/A' }} has been provided to support you in reducing everyday challenges associated with raising your grandchildren. We hope this assistance eases some of the financial burdens related to household needs, allowing you to continue providing a stable, loving, and nurturing environment for your grandchildren.
            </p>

            <h3>Payment Process:</h3>
            <p>
                Payments will be made directly to the service provider on your behalf. If applicable, please ensure that the provider is aware of the payment arrangement. Kindly send receipts of all purchases related to this grant. If any additional steps are needed from your end, we will notify you promptly.
            </p>

            <h3>Next Steps:</h3>
            <ul>
                <li>You may be contacted for any additional information required to process the payment.</li>
                <li>You will be required to return the receipt for verification after payment.</li>
                <li>Please stay in touch with us to ensure a smooth process and notify us of any changes in your circumstances.</li>
            </ul>

            <p>
                As part of our continued support, we invite you to stay connected with TGCN. We offer opportunities for advocacy, volunteering, and networking with other grandparents in similar situations.
            </p>

            <p>
                If you have any questions or need further clarification, please do not hesitate to contact us.
            </p>

            <p>
                We appreciate the dedication you have shown to your grandchildren, and we hope this assistance provides some relief in your current situation.
            </p>
        @endif
    </div>

    <div class="signature">
        <p><strong>Sincerely,</strong></p>
        <p><strong>Priscilla Yvonne Newbon</strong></p>
        <p>The Grandparents Community Network</p>
        <p>Executive Board Member</p>
        <p>Phone Number: (850) 491-3114</p>
        <p>Email: <a href="mailto:priscillanewbon@tgcncorporate.org">priscillanewbon@tgcncorporate.org</a></p>
    </div>

    <div class="footer">
        &copy; {{ \Carbon\Carbon::now()->year }} The Grandparents Community Network. All rights reserved.
    </div>
</div>
</body>
</html>
