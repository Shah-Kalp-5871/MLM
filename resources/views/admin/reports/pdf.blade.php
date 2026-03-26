<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>EliteMatrixPro - {{ strtoupper($range) }} Business Report</title>
    <style>
        @page {
            margin: 0cm 0cm;
        }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #2D3748;
            line-height: 1.5;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .header {
            background-color: #0F172A; /* Dark Navy */
            color: white;
            padding: 40px 50px;
            text-align: left;
            position: relative;
        }
        .logo-container {
            position: absolute;
            top: 40px;
            right: 50px;
        }
        .logo {
            height: 60px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #FBBF24; /* Gold */
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
            color: #94A3B8;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 2px;
        }
        .container {
            padding: 40px 50px;
        }
        .section-title {
            font-size: 14px;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748B;
            border-bottom: 2px solid #F1F5F9;
            padding-bottom: 8px;
            margin-bottom: 20px;
            margin-top: 30px;
        }
        .stats-grid {
            width: 100%;
            margin-bottom: 30px;
            border-spacing: 15px 0;
            margin-left: -15px;
            margin-right: -15px;
        }
        .stats-box {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            padding: 20px;
            border-radius: 12px;
            text-align: left;
        }
        .stats-label {
            font-size: 10px;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748B;
            margin-bottom: 5px;
        }
        .stats-value {
            font-size: 20px;
            font-weight: bold;
            color: #0F172A;
        }
        .table-container {
            background: #ffffff;
            border: 1px solid #E2E8F0;
            border-radius: 12px;
            overflow: hidden;
            margin-top: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th {
            background-color: #F8FAFC;
            color: #475569;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #E2E8F0;
        }
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #F1F5F9;
            font-size: 13px;
        }
        .text-right { text-align: right; }
        .text-success { color: #059669; }
        .text-primary { color: #4F46E5; }
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 9999px;
            font-size: 10px;
            font-weight: bold;
            background: #E2E8F0;
            color: #475569;
        }
        .footer {
            margin-top: 50px;
            padding: 30px 50px;
            background: #F8FAFC;
            border-top: 1px solid #E2E8F0;
            text-align: center;
        }
        .footer-text {
            font-size: 11px;
            color: #94A3B8;
        }
        .watermark {
            position: fixed;
            bottom: 20px;
            right: 50px;
            font-size: 40px;
            color: rgba(0,0,0,0.03);
            text-transform: uppercase;
            transform: rotate(-45deg);
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="watermark">EliteMatrixPro</div>

    <div class="header">
        <div class="logo-container">
            <img src="https://elitematrixpro.com/storage/logo.png" class="logo" alt="Logo">
        </div>
        <div class="company-name">EliteMatrixPro</div>
        <h1>Business Analytics Report</h1>
        <p>Generation Period: {{ $startDate }} — {{ $endDate }}</p>
    </div>

    <div class="container">
        <table class="stats-grid">
            <tr>
                <td width="25%" style="padding:0; border:none;">
                    <div class="stats-box">
                        <div class="stats-label">New Registrations</div>
                        <div class="stats-value text-primary">{{ number_format($data['users']['new']) }}</div>
                    </div>
                </td>
                <td width="25%" style="padding:0; border:none;">
                    <div class="stats-box">
                        <div class="stats-label">Total Volume</div>
                        <div class="stats-value">${{ number_format($data['investments']['total_amount'], 2) }}</div>
                    </div>
                </td>
                <td width="25%" style="padding:0; border:none;">
                    <div class="stats-box">
                        <div class="stats-label">Distributed Payouts</div>
                        <div class="stats-value text-success">${{ number_format($data['payouts']['total'], 2) }}</div>
                    </div>
                </td>
                <td width="25%" style="padding:0; border:none;">
                    <div class="stats-box">
                        <div class="stats-label">Processed Withdrawals</div>
                        <div class="stats-value">${{ number_format($data['withdrawals']['processed'], 2) }}</div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="section-title">Performance Analytics (Visual)</div>
        <table width="100%" style="margin-bottom: 20px;">
            <tr>
                <td width="50%" style="vertical-align: top; padding-right: 15px;">
                    <div style="font-size: 11px; font-weight: bold; color: #64748B; margin-bottom: 10px; text-transform: uppercase;">User Activity Ratio</div>
                    <div style="width: 100%; background: #F1F5F9; height: 12px; border-radius: 6px; overflow: hidden;">
                        <div style="width: {{ $data['kpis']['user_activity_rate'] }}%; background: #4F46E5; height: 100%;"></div>
                    </div>
                    <div style="font-size: 10px; color: #94A3B8; margin-top: 5px;">{{ $data['kpis']['user_activity_rate'] }}% of total base is active</div>
                </td>
                <td width="50%" style="vertical-align: top; padding-left: 15px;">
                    <div style="font-size: 11px; font-weight: bold; color: #64748B; margin-bottom: 10px; text-transform: uppercase;">Payout to Volume Rate</div>
                    <div style="width: 100%; background: #F1F5F9; height: 12px; border-radius: 6px; overflow: hidden;">
                        <div style="width: {{ $data['kpis']['payout_ratio'] > 100 ? 100 : $data['kpis']['payout_ratio'] }}%; background: #059669; height: 100%;"></div>
                    </div>
                    <div style="font-size: 10px; color: #94A3B8; margin-top: 5px;">{{ $data['kpis']['payout_ratio'] }}% ratio (Healthy)</div>
                </td>
            </tr>
        </table>

        <div class="section-title">Revenue & Commission Summary</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Metric Description</th>
                        <th>Total Amount</th>
                        <th class="text-right">Allocation Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>ROI Profit Distributions</td>
                        <td class="text-success"><strong>+ ${{ number_format($data['payouts']['roi_given'], 2) }}</strong></td>
                        <td class="text-right"><span class="badge">Disbursed</span></td>
                    </tr>
                    <tr>
                        <td>Level Commission Payouts</td>
                        <td class="text-success"><strong>+ ${{ number_format($data['payouts']['level_commissions'], 2) }}</strong></td>
                        <td class="text-right"><span class="badge">Disbursed</span></td>
                    </tr>
                    <tr>
                        <td>Active Investment Capital</td>
                        <td><strong>${{ number_format($data['investments']['active_amount'], 2) }}</strong></td>
                        <td class="text-right">Working</td>
                    </tr>
                    <tr>
                        <td>Lifetime Team Business (BV)</td>
                        <td class="text-primary"><strong>${{ number_format($data['business']['total_team_bv'], 2) }}</strong></td>
                        <td class="text-right">Platform Total</td>
                    </tr>
                    <tr style="background: #FFFBEB;">
                        <td>Pending Withdrawal Liability</td>
                        <td style="color: #D97706"><strong>${{ number_format($data['withdrawals']['pending'], 2) }}</strong></td>
                        <td class="text-right"><span class="badge" style="background:#FEF3C7; color:#92400E;">In Queue</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section-title">Voucher Ecosystem</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>E-Voucher Metrics</th>
                        <th>Volume/Value</th>
                        <th class="text-right">Circulation</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Vouchers Issued</td>
                        <td><strong>{{ $data['vouchers']['total_count'] }} Units</strong></td>
                        <td class="text-right">Total: ${{ number_format($data['vouchers']['total_value'], 2) }}</td>
                    </tr>
                    <tr>
                        <td>Active Unused Vouchers</td>
                        <td class="text-primary"><strong>${{ number_format($data['vouchers']['unused_value'], 2) }}</strong></td>
                        <td class="text-right">Available</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section-title">Membership Base Breakdown</div>
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>User Acquisition & Status</th>
                        <th>Headcount</th>
                        <th class="text-right">Engagement</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Growth in Period ({{ $startDate }} - {{ $endDate }})</td>
                        <td class="text-primary"><strong>+{{ number_format($data['users']['new']) }}</strong></td>
                        <td class="text-right">New Acquisition</td>
                    </tr>
                    <tr>
                        <td>Total Registered Users</td>
                        <td><strong>{{ number_format($data['users']['total']) }}</strong></td>
                        <td class="text-right">100% Base</td>
                    </tr>
                    <tr>
                        <td>Active Investors</td>
                        <td><strong>{{ number_format($data['users']['active']) }}</strong></td>
                        <td class="text-right" style="color: #4F46E5">{{ $data['kpis']['user_activity_rate'] }}% Conversion</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="section-title">Club Achiever Performance</div>
        @if(count($data['clubs']) > 0)
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Achieved Ranking</th>
                        <th class="text-right">Number of Members</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['clubs'] as $level => $count)
                    <tr>
                        <td><strong>Ranking Level {{ $level }}</strong></td>
                        <td class="text-right">{{ $count }} Achievers</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="background: #F8FAFC; padding: 20px; border-radius: 12px; text-align: center; color: #94A3B8; font-size: 13px;">
            No significant club achievements recorded for this reporting cycle.
        </div>
        @endif
    </div>

    <div class="footer">
        <p class="footer-text"><strong>Confidential Proprietary Information — EliteMatrixPro</strong></p>
        <p class="footer-text">This report is automatically synthesized from real-time core data.</p>
        <p class="footer-text" style="margin-top: 10px; font-weight: bold; color: #64748B;">Generated: {{ $generatedAt }} | Node Auth: {{ substr(md5($generatedAt), 0, 16) }}</p>
    </div>
</body>
</html>
