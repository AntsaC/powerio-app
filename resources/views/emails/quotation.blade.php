<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 40px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #2563eb;
        }

        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }

        .header p {
            color: #6b7280;
            margin: 10px 0 0 0;
            font-size: 16px;
        }

        .content {
            margin: 30px 0;
        }

        .content p {
            margin: 15px 0;
            font-size: 16px;
        }

        .quotation-details {
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
            padding: 20px;
            margin: 25px 0;
            border-radius: 4px;
        }

        .quotation-details h2 {
            margin: 0 0 15px 0;
            color: #2563eb;
            font-size: 18px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #4b5563;
        }

        .detail-value {
            color: #1f2937;
        }

        .total-amount {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
        }

        .cta-button {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            margin: 20px 0;
            text-align: center;
        }

        .cta-button:hover {
            background-color: #1d4ed8;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 14px;
        }

        .footer p {
            margin: 5px 0;
        }

        .attachment-notice {
            background-color: #fef3c7;
            border: 1px solid #fbbf24;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
            font-size: 14px;
            color: #92400e;
        }

        .attachment-notice strong {
            display: block;
            margin-bottom: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>New Quotation</h1>
            <p>{{ $quotation->quotation_number ?? 'Draft' }}</p>
        </div>

        <div class="content">
            <p>Dear {{ $quotation->project->customer->name ?? 'Valued Customer' }},</p>

            <p>Thank you for your interest in our solar energy solutions. Please find attached your quotation for the <strong>{{ $quotation->project->name }}</strong> project.</p>

            <div class="quotation-details">
                <h2>Quotation Summary</h2>

                <div class="detail-row">
                    <span class="detail-label">Quotation Number:</span>
                    <span class="detail-value">{{ $quotation->quotation_number ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Date:</span>
                    <span class="detail-value">{{ $quotation->quotation_date?->format('M d, Y') ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Valid Until:</span>
                    <span class="detail-value">{{ $quotation->valid_until?->format('M d, Y') ?? 'N/A' }}</span>
                </div>

                <div class="detail-row">
                    <span class="detail-label">Project:</span>
                    <span class="detail-value">{{ $quotation->project->name }}</span>
                </div>

                @if($quotation->project->system_capacity)
                    <div class="detail-row">
                        <span class="detail-label">System Capacity:</span>
                        <span class="detail-value">{{ $quotation->project->system_capacity }} kW</span>
                    </div>
                @endif

                <div class="detail-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value total-amount">${{ number_format($quotation->total_amount, 2) }}</span>
                </div>
            </div>

            <div class="attachment-notice">
                <strong>📎 Attachment Included</strong>
                A detailed PDF quotation is attached to this email with complete line items, pricing breakdown, and terms.
            </div>

            <p>This quotation is valid until <strong>{{ $quotation->valid_until?->format('F d, Y') ?? 'the date specified in the attached document' }}</strong>. If you have any questions or would like to discuss this quotation further, please don't hesitate to contact us.</p>

            <p>We look forward to working with you on this project and helping you achieve your renewable energy goals.</p>
        </div>

        <div class="footer">
            <p><strong>{{ config('app.name') }}</strong></p>
            <p>This is an automated email. Please do not reply directly to this message.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
