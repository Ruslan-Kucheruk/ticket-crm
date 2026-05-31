<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin Panel' }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container d-flex justify-content-between">
            <span class="navbar-brand mb-0 h1">Ticket CRM</span>
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-sm btn-outline-light">
                Tickets
            </a>
        </div>
    </nav>

    <main class="container">
        @yield('content')
    </main>
</body>

</html>
