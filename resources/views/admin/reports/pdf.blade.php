<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Business Report - {{ strtoupper($range) }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #1a1a1a;
            color: white;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            letter-spacing: 2px;
        }
        .header p {
            margin: 10px 0 0;
            font-size: 14px;
            opacity: 0.8;
        }
        .container {
            padding: 40px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 40px;
        }
        .stats-box {
            background: #f9f9f9;
            border: 1px solid #eee;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
        }
        .stats-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            color: #888;
            margin-bottom: 5px;
        }
        .stats-value {
            font-size: 20px;
            font-weight: bold;
            color: #111;
        }
        h2 {
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
            margin-top: 40px;
            font-size: 18px;
            text-transform: uppercase;
            color: #555;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        th {
            background-color: #fcfcfc;
            color: #888;
            font-size: 11px;
            text-transform: uppercase;
        }
        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 10px;
            color: #aaa;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }
        .kpi-row {
            margin-top: 10px;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
            background: #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>BUSINESS ANALYTICS REPORT</h1>
        <p>Report Duration: {{ $startDate }} to {{ $endDate }}</p>
    </div>

    <div class="container">
        <table class="stats-grid">
            <tr>
                <td width="25%">
                    <div class="stats-box">
                        <div class="stats-label">New Users</div>
                        <div class="stats-value">{{ number_format($data['users']['new']) }}</div>
                    </div>
                </td>
                <td width="25%">
                    <div class="stats-box">
                        <div class="stats-label">Total Investments</div>
                        <div class="stats-value">${{ number_format($data['investments']['total_amount'], 2) }}</div>
                    </div>
                </td>
                <td width="25%">
                    <div class="stats-box">
                        <div class="stats-label">Total Payouts</div>
                        <div class="stats-value">${{ number_format($data['payouts']['total'], 2) }}</div>
                    </div>
                </td>
                <td width="25%">
                    <div class="stats-box">
                        <div class="stats-label">Withdrawals (Paid)</div>
                        <div class="stats-value">${{ number_format($data['withdrawals']['processed'], 2) }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <h2>Detailed Financial Summary</h2>
        <table>
            <thead>
                <tr>
                    <th>Metric Type</th>
                    <th>Value / Capacity</th>
                    <th>Status / Period</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ROI Distributions</td>
                    <td><strong>${{ number_format($data['payouts']['roi_given'], 2) }}</strong></td>
                    <td>Distributed</td>
                </tr>
                <tr>
                    <td>Level Commissions</td>
                    <td><strong>${{ number_format($data['payouts']['level_commissions'], 2) }}</strong></td>
                    <td>Distributed</td>
                </tr>
                <tr>
                    <td>Direct Business Volume (Total)</td>
                    <td><strong>${{ number_format($data['business']['total_direct_bv'], 2) }}</strong></td>
                    <td>Lifetime</td>
                </tr>
                <tr>
                    <td>Team Business Volume (Total)</td>
                    <td><strong>${{ number_format($data['business']['total_team_bv'], 2) }}</strong></td>
                    <td>Lifetime</td>
                </tr>
                <tr>
                    <td>Pending Withdrawals</td>
                    <td><strong>${{ number_format($data['withdrawals']['pending'], 2) }}</strong></td>
                    <td><span class="badge">Awaiting Action</span></td>
                </tr>
            </tbody>
        </table>

        <h2>Network & User Growth</h2>
        <table>
            <thead>
                <tr>
                    <th>User Metric</th>
                    <th>Current Count</th>
                    <th>Percentage / Growth</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Total Registered Users</td>
                    <td>{{ number_format($data['users']['total']) }}</td>
                    <td>-</td>
                </tr>
                <tr>
                    <td>Active Users (with investments)</td>
                    <td>{{ number_format($data['users']['active']) }}</td>
                    <td>{{ $data['users']['total'] > 0 ? round(($data['users']['active'] / $data['users']['total']) * 100, 1) : 0 }}% Activity</td>
                </tr>
                <tr>
                    <td>Inactive Users</td>
                    <td>{{ number_format($data['users']['inactive']) }}</td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>

        <h2>Club Level Achievement Summary</h2>
        @if(count($data['clubs']) > 0)
        <table>
            <thead>
                <tr>
                    <th>Club Level</th>
                    <th>Number of Achievers</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['clubs'] as $level => $count)
                <tr>
                    <td>Level {{ $level }}</td>
                    <td><strong>{{ $count }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="font-size: 12px; color: #888;">No club achievements recorded in this period.</p>
        @endif

        <div class="footer">
            <p>Generated by EliteMatrixPro System Auto-Reporting Tool</p>
            <p>Timestamp: {{ $generatedAt }} | System Analytics ID: {{ md5($generatedAt) }}</p>
        </div>
    </div>
</body>
</html>
