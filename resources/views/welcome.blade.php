<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('MondialLogo.svg') }}" type="image/x-icon" />
    <title>Mondial Prestige</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')
</head>

<body class="antialiased">
    <a href="https://stock-management.test/admin" class="text-center hover:underline text-3xl text-blue-800">
        Go to Admin Panel
    </a>

</body>

</html>
