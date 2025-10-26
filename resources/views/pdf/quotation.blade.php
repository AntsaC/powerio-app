<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            padding: 40px;
        }

        .header {
            margin-bottom: 40px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .header-info {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .company-info {
            flex: 1;
        }

        .quotation-info {
            flex: 1;
            text-align: right;
        }

        .info-block {
            margin-bottom: 30px;
        }

        .info-block h3 {
            font-size: 14px;
            color: #2563eb;
            margin-bottom: 10px;
            text-transform: uppercase;
            font-weight: bold;
        }

        .info-block p {
            margin: 5px 0;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-row > div {
            flex: 1;
            margin-right: 20px;
        }

        .info-row > div:last-child {
            margin-right: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        table thead {
            background-color: #2563eb;
            color: white;
        }

        table thead th {
            padding: 12px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
            text-transform: uppercase;
        }

        table tbody td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        table tbody tr:last-child td {
            border-bottom: 2px solid #2563eb;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            margin-top: 20px;
            float: right;
            width: 300px;
        }

        .totals table {
            margin: 0;
        }

        .totals table td {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .totals table tr:last-child {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            font-size: 14px;
        }

        .totals table tr:last-child td {
            border-bottom: none;
        }

        .notes {
            clear: both;
            margin-top: 40px;
            padding: 20px;
            background-color: #f9fafb;
            border-left: 4px solid #2563eb;
        }

        .notes h3 {
            font-size: 14px;
            margin-bottom: 10px;
            color: #2563eb;
        }

        .footer {
            margin-top: 60px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
        }

        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-approved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .badge-sent {
            background-color: #dbeafe;
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>QUOTATION</h1>
        <div class="header-info">
            <div class="company-info">
                <p style="font-size: 18px; font-weight: bold;">Your Company Name</p>
                <p>123 Business Street</p>
                <p>City, State 12345</p>
                <p>Phone: (123) 456-7890</p>
                <p>Email: info@company.com</p>
            </div>
            <div class="quotation-info">
                <p><strong>Quotation #:</strong> {{ $quotation->quotation_number ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $quotation->quotation_date?->format('M d, Y') ?? 'N/A' }}</p>
                <p><strong>Valid Until:</strong> {{ $quotation->valid_until?->format('M d, Y') ?? 'N/A' }}</p>
                <p>
                    <strong>Status:</strong>
                    <span class="badge badge-{{ $quotation->status }}">{{ ucfirst($quotation->status) }}</span>
                </p>
            </div>
        </div>
    </div>

    <div class="info-row">
        <div class="info-block">
            <h3>Customer Information</h3>
            @if($customer)
                <p><strong>{{ $customer->name }}</strong></p>
                @if($customer->company)
                    <p>{{ $customer->company }}</p>
                @endif
                @if($customer->address)
                    <p>{{ $customer->address }}</p>
                @endif
                @if($customer->city || $customer->state || $customer->postal_code)
                    <p>{{ collect([$customer->city, $customer->state, $customer->postal_code])->filter()->implode(', ') }}</p>
                @endif
                @if($customer->country)
                    <p>{{ $customer->country }}</p>
                @endif
                @if($customer->email)
                    <p>Email: {{ $customer->email }}</p>
                @endif
                @if($customer->phone)
                    <p>Phone: {{ $customer->phone }}</p>
                @endif
            @else
                <p>N/A</p>
            @endif
        </div>

        <div class="info-block">
            <h3>Project Information</h3>
            <p><strong>{{ $project->name }}</strong></p>
            @if($project->description)
                <p>{{ $project->description }}</p>
            @endif
            @if($project->location)
                <p>Location: {{ $project->location }}</p>
            @endif
            @if($project->system_capacity)
                <p>System Capacity: {{ $project->system_capacity }} kW</p>
            @endif
            @if($project->installation_type)
                <p>Installation Type: {{ ucfirst(str_replace('_', ' ', $project->installation_type)) }}</p>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 50%;">Description</th>
                <th class="text-center" style="width: 10%;">Qty</th>
                <th class="text-right" style="width: 15%;">Unit Price</th>
                <th class="text-right" style="width: 10%;">Discount</th>
                <th class="text-right" style="width: 15%;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lines as $line)
                <tr>
                    <td>
                        <strong>{{ $line['description'] }}</strong>
                        @if($line['notes'])
                            <br><small style="color: #6b7280;">{{ $line['notes'] }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $line['quantity'] }}</td>
                    <td class="text-right">${{ number_format($line['unit_price'], 2) }}</td>
                    <td class="text-right">
                        @if($line['discount_percentage'] > 0)
                            {{ number_format($line['discount_percentage'], 0) }}%
                            <br><small>(${{ number_format($line['discount_amount'], 2) }})</small>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right"><strong>${{ number_format($line['line_total'], 2) }}</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px;">No items found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">${{ number_format($totals['subtotal'], 2) }}</td>
            </tr>
            @if($totals['discount_amount'] > 0)
                <tr>
                    <td>Discount:</td>
                    <td class="text-right">-${{ number_format($totals['discount_amount'], 2) }}</td>
                </tr>
            @endif
            <tr>
                <td>Tax ({{ number_format($totals['tax_rate'], 0) }}%):</td>
                <td class="text-right">${{ number_format($totals['tax_amount'], 2) }}</td>
            </tr>
            <tr>
                <td>TOTAL:</td>
                <td class="text-right">${{ number_format($totals['total_amount'], 2) }}</td>
            </tr>
        </table>
    </div>

    @if($quotation->notes)
        <div class="notes">
            <h3>Notes & Terms</h3>
            <p>{{ $quotation->notes }}</p>
        </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>This quotation is valid until {{ $quotation->valid_until?->format('M d, Y') ?? 'N/A' }}</p>
    </div>
</body>
</html>
