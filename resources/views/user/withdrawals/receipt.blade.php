<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Withdrawal Receipt #{{ $withdrawal->id }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f7f6;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #eee;
            margin-bottom: 30px;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #10b981; /* bg-emerald-500 equivalent */
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .receipt-title {
            font-size: 18px;
            color: #666;
            margin-top: 5px;
        }
        .details {
            margin-bottom: 30px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #f9f9f9;
        }
        .row:last-child {
            border-bottom: none;
        }
        .label {
            font-weight: 600;
            color: #555;
        }
        .value {
            font-weight: 700;
            color: #111;
        }
        .status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 40px;
        }
        .print-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background: #10b981;
            color: #fff;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            border: none;
            cursor: pointer;
        }
        @media print {
            .print-btn {
                display: none;
            }
            body {
                background: #fff;
                padding: 0;
            }
            .container {
                box-shadow: none;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">EliteMatrixPro</div>
            <div class="receipt-title">Withdrawal Receipt</div>
        </div>
        
        <div class="details">
            <div class="row">
                <span class="label">Receipt ID</span>
                <span class="value">#W-{{ str_pad($withdrawal->id, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
            <div class="row">
                <span class="label">Date</span>
                <span class="value">{{ $withdrawal->created_at->format('d M Y, h:i A') }}</span>
            </div>
            <div class="row">
                <span class="label">User</span>
                <span class="value">{{ $withdrawal->user->name }}</span>
            </div>
            <div class="row">
                <span class="label">Method</span>
                <span class="value">{{ $withdrawal->method }}</span>
            </div>
            <div class="row">
                <span class="label">Amount</span>
                <span class="value" style="font-size: 20px; color: #10b981;">{{ $settings['platform_currency_symbol'] ?? '$' }}{{ number_format($withdrawal->amount, 2) }}</span>
            </div>
            <div class="row">
                <span class="label">Status</span>
                <span class="value">
                    <span class="status status-{{ $withdrawal->status }}">
                        {{ ucfirst($withdrawal->status) }}
                    </span>
                </span>
            </div>
            @if($withdrawal->admin_note)
            <div class="row" style="flex-direction: column; align-items: flex-start;">
                <span class="label">Admin Note:</span>
                <span class="value" style="margin-top: 5px; font-weight: 400; color: #666;">{{ $withdrawal->admin_note }}</span>
            </div>
            @endif
        </div>
        
        <div class="footer">
            <p>This is a computer-generated receipt.</p>
            <p>&copy; {{ date('Y') }} EliteMatrixPro. All rights reserved.</p>
        </div>
        
        <button class="print-btn" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>
