<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <title>Influencia</title>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
        <link href="{{ asset('css/app.css') }}?v={{ config('scraper.version') }}" rel="stylesheet"/>
    </head>
    <body>
        <div id="app">
            <App></App>
        </div>
        
        <script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
