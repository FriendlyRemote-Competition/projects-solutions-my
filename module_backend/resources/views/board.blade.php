<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset("public/bootstrap/css/bootstrap.min.css") }}">
    <title>Station Index</title>
</head>
<body class="">
    <main class="card shadow">
        <div class="card-body">
            <h2>Stations</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Link</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($stations as $station)
                        <tr>
                            <td>{{ $station->name }}</td>
                            <td><a class="btn btn-primary" href="{{ url('/board/'.$station->code) }}">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>
