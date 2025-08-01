<!DOCTYPE html>
<html>
<head>
    <title>Gestor de Tickets</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Bootstrap opcional --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="#">Gestor de Tickets</a>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
