<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kan Sann Messenger Bot</title>
    @vite('resources/css/app.css')
</head>

<body class="text-white bg-dark">
    <div class="container mx-auto">
        <div id="app"></div>
    </div>
    @vite('resources/js/app.js')
</body>

</html>
