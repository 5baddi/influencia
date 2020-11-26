<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Influencia</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link href="//fonts.googleapis.com/css?family=Roboto:400,500,700,400italic|Material+Icons" rel="stylesheet"/>
        <link href="{{ asset('css/app.css') }}?v={{ env('APP_VERSION') }}" rel="stylesheet"/>
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
