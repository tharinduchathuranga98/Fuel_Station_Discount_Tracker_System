<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Report - {{ $month }}</title>
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-bg: #f8f9fa;
            --border-color: #ddd;
            --success-color: #5cb85c;
            --warning-color: #f0ad4e;
            --info-color: #5bc0de;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--light-bg);
        }

        .report-container {
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-bottom: 30px;
        }

        .report-header {
            border-bottom: 2px solid var(--secondary-color);
            margin-bottom: 25px;
            padding-bottom: 15px;
            position: relative;
        }

        h1, h2, h3 {
            color: var(--primary-color);
            margin: 0;
        }

        h1 {
            font-size: 28px;
            text-align: center;
        }

        h2 {
            font-size: 22px;
            margin-top: 30px;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--border-color);
        }

        .date-range {
            background-color: var(--secondary-color);
            color: white;
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f7fe;
        }

        .totals-container {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .total-card {
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            flex: 1;
            min-width: 200px;
            margin: 0 10px 10px 0;
            text-align: center;
        }

        .total-card.sales {
            border-top: 4px solid var(--secondary-color);
        }

        .total-card.discounts {
            border-top: 4px solid var(--accent-color);
        }

        .total-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .total-value {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .fuel-type-label {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 500;
            margin-right: 8px;
        }

        .diesel {
            background-color: var(--warning-color);
            color: white;
        }

        .petrol {
            background-color: var(--success-color);
            color: white;
        }

        .cng {
            background-color: var(--info-color);
            color: white;
        }

        .fuel-section {
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .fuel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .fuel-header h3 {
            margin: 0;
            display: flex;
            align-items: center;
            font-size: 20px;
        }

        .fuel-summary {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 5px;
        }

        .fuel-summary-item {
            background-color: white;
            padding: 8px 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .detailed-records {
            padding: 0;
        }

        .detailed-table {
            margin: 0;
            box-shadow: none;
        }

        .detailed-table th {
            background-color: #e9ecef;
            color: #495057;
        }

        .detailed-table td {
            font-size: 14px;
        }

        .date-column {
            width: 180px;
        }

        .print-btn {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
        }

        .print-btn:hover {
            background-color: #1a2530;
        }

        .print-icon {
            margin-right: 8px;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 12px;
            padding-top: 20px;
            border-top: 1px solid var(--border-color);
        }

        .page-header {
            border-bottom: 1px solid var(--border-color);
            padding-bottom: 10px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            margin: 0;
            font-size: 18px;
            color: var(--primary-color);
        }

        .page-info {
            color: #777;
            font-size: 14px;
        }

        /* Page break styles */
        .detailed-section {
            margin-top: 60px;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .report-container {
                box-shadow: none;
                padding: 15px;
            }

            .print-btn {
                display: none;
            }

            /* Fix for page breaks */
            .summary-section {
                page-break-after: always;
            }

            .fuel-section {
                page-break-before: always;
                page-break-after: auto;
                page-break-inside: avoid;
                border: none;
                border-top: 1px solid #eee;
            }

            /* Don't break the first fuel section after the summary */
            .fuel-section:first-of-type {
                page-break-before: auto;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            thead {
                display: table-header-group;
            }

            tfoot {
                display: table-footer-group;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Summary Page -->
        <div class="summary-section">
            <div class="report-header">
                <h1>Monthly Refueling Report</h1>
                <div style="text-align: center; margin-top: 10px;">
                    <span class="date-range"><strong>Month:</strong> {{ $month }} ({{ $startDate }} - {{ $endDate }})</span>
                    <span class="date-range"><strong>Report Type:</strong> {{ ucfirst($reportType) }}</span>
                </div>
            </div>

            <h2>Summary</h2>
            <table>
                <thead>
                    <tr>
                        <th>Fuel Type</th>
                        <th>Total Liters</th>
                        <th>Total Sales (Rs.)</th>
                        <th>Total Discount (Rs.)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($fuelData as $data)
                        <tr>
                            <td>
                                <span class="fuel-type-label {{ strtolower($data['fuel_type']) }}">
                                    {{ $data['fuel_type'] }}
                                </span>
                            </td>
                            <td>{{ number_format($data['total_liters'], 2) }}</td>
                            <td>Rs. {{ number_format($data['total_sales'], 2) }}</td>
                            <td>Rs. {{ number_format($data['total_discount'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="totals-container">
                <div class="total-card sales">
                    <div class="total-label">Total Sales</div>
                    <div class="total-value">Rs. {{ number_format(array_sum(array_column($fuelData, 'total_sales')), 2) }}</div>
                </div>
                <div class="total-card discounts">
                    <div class="total-label">Total Discounts</div>
                    <div class="total-value">Rs. {{ number_format(array_sum(array_column($fuelData, 'total_discount')), 2) }}</div>
                </div>
            </div>


        </div>

        <!-- Detailed Section (Only shown for detailed report) -->
        @if ($reportType == 'detailed')
            <div class="detailed-section">
                @foreach ($fuelData as $index => $data)
                    <div class="fuel-section">
                        <div class="page-header">
                            <div class="page-title">Monthly Refueling Report - {{ $month }}</div>
                            {{-- <div class="page-info">Page {{ $index + 2 }} of {{ count($fuelData) + 1 }}</div> --}}
                        </div>

                        <div class="fuel-header">
                            <h3>
                                <span class="fuel-type-label {{ strtolower($data['fuel_type']) }}">{{ $data['fuel_type'] }}</span>
                                Transactions
                            </h3>
                            <div class="fuel-summary">
                                <div class="fuel-summary-item">
                                    <strong>Total:</strong> {{ count($data['records']) }} transactions
                                </div>
                                <div class="fuel-summary-item">
                                    <strong>Volume:</strong> {{ number_format($data['total_liters'], 2) }} liters
                                </div>
                                <div class="fuel-summary-item">
                                    <strong>Sales:</strong> Rs. {{ number_format($data['total_sales'], 2) }}
                                </div>
                            </div>
                        </div>

                        <div class="detailed-records">
                            <table class="detailed-table">
                                <thead>
                                    <tr>
                                        <th class="date-column">Date & Time</th>
                                        <th>Liters</th>
                                        {{-- <th>Rate (Rs.)</th> --}}
                                        <th>Price (Rs.)</th>
                                        <th>Discount (Rs.)</th>
                                        <th>Final Price (Rs.)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['records'] as $record)
                                        <tr>
                                            <td>{{ $record['refueled_at'] }}</td>
                                            <td>{{ number_format($record['liters'], 2) }}</td>
                                            {{-- <td>{{ number_format($record['rate'], 2) }}</td> --}}
                                            <td>{{ number_format($record['total_price'], 2) }}</td>
                                            <td>{{ number_format($record['total_discount'], 2) }}</td>
                                            <td>{{ number_format($record['total_price'] - $record['total_discount'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

    </div>

    <footer>
        Generated on {{ date('F d, Y') }} • Fuel Management System
    </footer>
</body>
</html>
