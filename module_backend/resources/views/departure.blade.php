<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("public/bootstrap/css/bootstrap.min.css") }}">
    <title>Departure Screen</title>
</head>
<body class="">
<main class="card shadow">
    <h1>Departures</h1>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Departure Time</th>
            <th>Line</th>
            <th>Destination Station</th>
            <th>Departure in</th>
            <th>Seats Available</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        @foreach($departures as $d)
            <tr>
                <td>{{ $d['departure_time'] }}</td>
                <td>{{ $d['line_code'] }}</td>
                <td>{{ substr($d['code'], -3) }}</td>
                <td>1 hour 20 minutes </td>
                <td>{{ $d['seats_available'] }}</td>
                <td>{{ $d['status'] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</main>
</body>
</html>
