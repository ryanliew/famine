<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Famine 30 - Game 1</title>

        <link rel="stylesheet" href="/css/app.css?v=1.1">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>
    <body>
        <div class="container-fluid text-center" id="app">
            <teams></teams>
        </div>

        <script src="/js/app.js?v=1.1"></script>
    </body>
</html>
