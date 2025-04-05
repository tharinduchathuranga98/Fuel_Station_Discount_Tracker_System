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

        h1 {
            color: var(--primary-color);
            margin: 0;
            font-size: 28px;
            text-align: center;
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
        }

        .diesel {
            background-color: #f0ad4e;
            color: white;
        }

        .petrol {
            background-color: #5cb85c;
            color: white;
        }

        .cng {
            background-color: #5bc0de;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: #777;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="report-header">
            <h1>Monthly Refueling Report</h1>
            <div style="text-align: center; margin-top: 10px;">
                <span class="date-range"><strong>Month:</strong> {{ $month }} ({{ $startDate }} - {{ $endDate }})</span>
            </div>
        </div>

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

    <footer>
        Generated on {{ date('F d, Y') }} • Fuel Management System
    </footer>
</body>
</html>
