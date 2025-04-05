<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Refueling Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>

    <h1>Refueling Report</h1>

    @if(request()->has('month'))
        <p>Report for the month of: {{ Carbon\Carbon::parse(request('month'))->format('F Y') }}</p>
    @endif

    @if(request()->has('start_date') && request()->has('end_date'))
        <p>Report from: {{ Carbon\Carbon::parse(request('start_date'))->format('d M, Y') }} to {{ Carbon\Carbon::parse(request('end_date'))->format('d M, Y') }}</p>
    @endif

    @if(request()->has('number_plate'))
        <p>Filter: Number Plate - {{ request('number_plate') }}</p>
    @endif

    @if(request()->has('company'))
        <p>Filter: Company - {{ request('company') }}</p>
    @endif

    @if(request()->has('mobile_number'))
        <p>Filter: Mobile Number - {{ request('mobile_number') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Number Plate</th>
                <th>Fuel Type</th>
                <th>Liters</th>
                <th>Total Price</th>
                <th>Total Discount</th>
                <th>Refueled At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($refuelingRecords as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->number_plate }}</td>
                    <td>{{ $record->fuel_type_name }}</td>
                    <td>{{ $record->liters }}</td>
                    <td>{{ $record->total_price }}</td>
                    <td>{{ $record->total_discount }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->refueled_at)->format('d M, Y H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
